<?php

namespace App\Controller;

use App\Form\AddressForm;
use App\Model\Address as Model;
use App\Service\AddressService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Route('/api')]
class ApiController extends AbstractController
{
    private SerializerInterface $serializer;

    private AddressService $service;

    /**
     * @param SerializerInterface $serializer
     * @param AddressService $service
     */
    public function __construct(SerializerInterface $serializer, AddressService $service)
    {
        $this->serializer = $serializer;
        $this->service = $service;
    }

    #[Route('', methods: ['GET'])]
    public function cgetAction(Request $request): Response
    {
        $limit = AddressService::LIMIT;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $limit;

        $addresses = $this->service->retrieveAll($offset, $limit);
        $count = $this->service->countAll();

        return new JsonResponse([
            'data' => $addresses,
            'count' => $count,
            'page' => $page,
            'pages' => ceil($count / $limit),
        ]);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getAction(int $id): Response
    {
        if (!($address = $this->service->retrieve($id))) {
            throw new NotFoundHttpException(sprintf('Address #%s not found.', $id));
        }

        return new JsonResponse($address);
    }

    #[Route('/create', methods: ['GET'])]
    public function createFormAction(): Response
    {
        $address = new Model();
        $form = $this->createForm(AddressForm::class, $address);

        return $this->render('address/form.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('', methods: ['POST'])]
    public function postAction(Request $request): Response
    {
        try {
            $address = $this->service->create($this->serializer->deserialize(
                $request->getContent(),
                Model::class,
                JsonEncoder::FORMAT
            ));
        } catch (ValidationFailedException $e) {
            return new JsonResponse(
                $this->serializer->normalize($e->getViolations()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return new JsonResponse($address);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function putAction(int $id, Request $request): Response
    {
        try {
            $address = $this->service->update($id, $this->serializer->deserialize(
                $request->getContent(),
                Model::class,
                JsonEncoder::FORMAT
            ));
        } catch (ValidationFailedException $e) {
            return new JsonResponse(
                $this->serializer->normalize($e->getViolations()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return new JsonResponse($address);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteAction(int $id): Response
    {
        $this->service->delete($id);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
