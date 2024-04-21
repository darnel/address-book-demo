<?php

namespace App\Repository;

trait CrudTrait
{
    /**
     * Create entity helper
     *
     * @param object $entity
     * @return object
     */
    public function create(object $entity): object
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     * Update entity helper
     *
     * @param object $entity
     * @return object
     */
    public function update(object $entity): object
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     * Delete entity helper
     *
     * @param object $entity
     * @return void
     */
    public function delete(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
