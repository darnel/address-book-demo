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
    public function create(object $entity)
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
    public function update(object $entity)
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
    public function delete(object $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
