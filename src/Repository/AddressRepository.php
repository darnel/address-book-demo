<?php

namespace App\Repository;

use App\Entity\Address;
use App\Service\AddressService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ServiceEntityRepository
{
    use CrudTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * List all addresses sorted and paged
     *
     * @param int $offset
     * @param int $limit
     * @return array|Address[]
     */
    public function findAllPaged(int $offset = 0, int $limit = AddressService::LIMIT): array
    {
        return $this->findBy([], ['lastName' => 'ASC', 'firstName' => 'ASC'], $limit, $offset);
    }
}
