<?php

namespace App\Service;

use App\Entity\Address as Entity;
use App\Model\Address as Model;
use App\Repository\AddressRepository;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressService
{
    public const LIMIT = 15;

    /** @var AddressRepository */
    private $repository;

    /** @var AddressTransformer */
    private $transformer;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param AddressRepository $repository
     * @param AddressTransformer $transformer
     * @param ValidatorInterface $validator
     */
    public function __construct(AddressRepository $repository, AddressTransformer $transformer, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    /**
     * List all addresses
     *
     * @param int $offset
     * @param int $limit
     * @return array|Model[]
     */
    public function retrieveAll(int $offset = 0, int $limit = self::LIMIT): array
    {
        return array_map(
            [$this->transformer, 'toModel'],
            $this->repository->findAllPaged($offset, $limit)
        );
    }

    /**
     * Count all addresses for paging purposes
     *
     * @return int
     */
    public function countAll(): int
    {
        return $this->repository->count();
    }

    /**
     * Retrieve address by given ID or return null if not found
     *
     * @param int $id
     * @return Model|null
     */
    public function retrieve(int $id): ?Model
    {
        $entity = $this->repository->find($id);

        return $this->transformer->toModel($entity);
    }

    /**
     * Create address
     *
     * @param Model $model
     * @return Model
     */
    public function create(Model $model): Model
    {
        if (($violations = $this->validator->validate($model)) && $violations->count()) {
            throw new ValidationFailedException($model, $violations);
        }

        $entity = $this->transformer->toEntity($model);
        /** @var Entity $entity */
        $entity = $this->repository->create($entity);

        return $this->transformer->toModel($entity);
    }

    /**
     * Update address by given ID or return null if not found
     *
     * @param int $id
     * @param Model $model
     * @return Model|null
     */
    public function update(int $id, Model $model): ?Model
    {
        if (null === ($entity = $this->repository->find($id))) {
            return null;
        }

        if (($violations = $this->validator->validate($model)) && $violations->count()) {
            throw new ValidationFailedException($model, $violations);
        }

        $entity = $this->transformer->toEntity($model, $entity);
        /** @var Entity $entity */
        $entity = $this->repository->update($entity);

        return $this->transformer->toModel($entity);
    }

    /**
     * Delete address by given ID, do nothing if not found
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        if (!($entity = $this->repository->find($id))) {
            return;
        }
        $this->repository->delete($entity);
    }
}
