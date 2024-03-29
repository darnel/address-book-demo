<?php

namespace App\Service;

use App\Entity\Address as Entity;
use App\Model\Address as Model;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AddressTransformer
{
    /**
     * Transform model (DTO) to ORM entity
     *
     * @param Model|null $model
     * @param Entity|null $entity
     * @return Entity|null
     */
    public function toEntity(?Model $model, ?Entity $entity = null): mixed
    {
        if (null === $model) {
            return null;
        }

        if (null === $entity) {
            $entity = new Entity();
        }

        $entity
            ->setFirstName($model->firstName)
            ->setLastName($model->lastName)
            ->setEmail($model->email)
            ->setPhone($model->phone)
            ->setNote($model->note);

        return $entity;
    }

    /**
     * Transform ORM entity to model (DTO)
     *
     * @param Entity|null $entity
     * @return Model|null
     */
    public function toModel(?Entity $entity)
    {
        if (null === $entity) {
            return null;
        }

        $model = new Model();
        $model->id = $entity->getId();
        $model->firstName = $entity->getFirstName();
        $model->lastName = $entity->getLastName();
        $model->email = $entity->getEmail();
        $model->phone = $entity->getPhone();
        $model->note = $entity->getNote();
        // generate URL slug
        $model->slug = (new AsciiSlugger())->slug(
            strtolower(sprintf('%s-%s', $model->firstName, $model->lastName))
        );

        return $model;
    }
}
