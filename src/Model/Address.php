<?php

namespace App\Model;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    public ?int $id = null;

    #[Assert\NotBlank(message: 'Jméno nesmí být prázdné')]
    public string $firstName;

    #[Assert\NotBlank(message: 'Příjmení nesmí být prázdné')]
    public string $lastName;

    public ?string $phone = null;

    #[Assert\NotBlank(message: 'E-mail nesmí být prázdný')]
    #[Assert\Email(message: 'E-mail není správně zadaný')]
    public string $email;

    public ?string $note = null;

    public ?string $slug = null;
}
