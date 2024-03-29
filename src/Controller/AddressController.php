<?php

namespace App\Controller;

use App\Form\AddressForm;
use App\Model\Address as Model;
use App\Service\AddressService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddressController extends AbstractController
{
    /** @var AddressService */
    private $service;

    /**
     * @param AddressService $service
     */
    public function __construct(AddressService $service)
    {
        $this->service = $service;
    }

    /**
     * List of addresses
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/', methods: ['GET'])]
    public function indexAction(Request $request): Response
    {
        $limit = AddressService::LIMIT;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $limit;

        $addresses = $this->service->retrieveAll($offset, $limit);
        $count = $this->service->countAll();

        if ($count === 0) {
            $this->addFlash('info', 'Adresář neobsahuje žádné položky');
        }

        return $this->render('address/index.html.twig', [
            'data' => $addresses,
            'count' => $count,
            'page' => $page,
            'pages' => ceil($count / $limit),
        ]);
    }

    /**
     * Create form and processing
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/create', methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $address = new Model();
        $form = $this->createForm(AddressForm::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->create($address);
            return new RedirectResponse($this->generateUrl('app_address_index'));
        }

        return $this->render('address/form.html.twig', [
            'form' => $form,
            'id' => null,
        ]);
    }

    /**
     * Update form (detail) and processing
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    #[Route('/{id}-{slug}', methods: ['GET', 'POST', 'PUT'], requirements: ['id' => '\d+'])]
    #[Route('/{id}', methods: ['GET', 'POST', 'PUT'], requirements: ['id' => '\d+'])]
    public function updateAction(Request $request, int $id): Response
    {
        if (!($address = $this->service->retrieve($id))) {
            $this->addFlash('danger', sprintf('Adresa #%s nenalezena', $id));
            return new RedirectResponse($this->generateUrl('app_address_index'));
        }
        $form = $this->createForm(AddressForm::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->update($id, $address);
            return new RedirectResponse($this->generateUrl('app_address_index'));
        }

        return $this->render('address/form.html.twig', [
            'form' => $form,
            'id' => $id,
            'slug' => $address->slug,
        ]);
    }

    /**
     * Delete address
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    #[Route('/{id}-{slug}/delete', methods: ['GET'], requirements: ['id' => '\d+'])]
    #[Route('/{id}/delete', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function deleteAction(Request $request, int $id): Response
    {
        if (!($address = $this->service->retrieve($id))) {
            $this->addFlash('danger', sprintf('Adresa #%s nenalezena', $id));
            return new RedirectResponse($this->generateUrl('app_address_index'));
        }

        $this->service->delete($id, $address);

        return new RedirectResponse($this->generateUrl('app_address_index'));
    }
}
