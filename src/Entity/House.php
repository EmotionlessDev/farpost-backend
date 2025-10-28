<?php

namespace App\Entity;

use App\Repository\HouseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HouseRepository::class)]
class House
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 9, scale: 6)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 9, scale: 6)]
    private ?string $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'houses')]
    private ?ManagingCompany $managing_company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getManagingCompany(): ?ManagingCompany
    {
        return $this->managing_company;
    }

    public function setManagingCompany(?ManagingCompany $managing_company): static
    {
        $this->managing_company = $managing_company;

        return $this;
    }
}
