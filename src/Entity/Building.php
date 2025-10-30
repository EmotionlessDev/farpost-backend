<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildingRepository::class)]
class Building
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Street $street = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?District $district = null;

    #[ORM\Column]
    private ?bool $is_fake = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    private ?FolkDistrict $folk_district = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    private ?BigFolkDistrict $big_folk_district = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\Column(length: 255)]
    private ?string $coordinates = null;

    /**
     * @var Collection<int, Blackout>
     */
    #[ORM\ManyToMany(targetEntity: Blackout::class, mappedBy: 'building')]
    private Collection $blackouts;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organizations $organization = null;

    public function __construct()
    {
        $this->blackouts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?Street
    {
        return $this->street;
    }

    public function setStreet(?Street $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): static
    {
        $this->district = $district;

        return $this;
    }

    public function isFake(): ?bool
    {
        return $this->is_fake;
    }

    public function setIsFake(bool $is_fake): static
    {
        $this->is_fake = $is_fake;

        return $this;
    }

    public function getFolkDistrict(): ?FolkDistrict
    {
        return $this->folk_district;
    }

    public function setFolkDistrict(?FolkDistrict $folk_district): static
    {
        $this->folk_district = $folk_district;

        return $this;
    }

    public function getBigFolkDistrict(): ?BigFolkDistrict
    {
        return $this->big_folk_district;
    }

    public function setBigFolkDistrict(?BigFolkDistrict $big_folk_district): static
    {
        $this->big_folk_district = $big_folk_district;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCoordinates(): ?string
    {
        return $this->coordinates;
    }

    public function setCoordinates(string $coordinates): static
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * @return Collection<int, Blackout>
     */
    public function getBlackouts(): Collection
    {
        return $this->blackouts;
    }

    public function addBlackout(Blackout $blackout): static
    {
        if (!$this->blackouts->contains($blackout)) {
            $this->blackouts->add($blackout);
            $blackout->addBuilding($this);
        }

        return $this;
    }

    public function removeBlackout(Blackout $blackout): static
    {
        if ($this->blackouts->removeElement($blackout)) {
            $blackout->removeBuilding($this);
        }

        return $this;
    }

    public function getOrganization(): ?Organizations
    {
        return $this->organization;
    }

    public function setOrganization(?Organizations $organization): static
    {
        $this->organization = $organization;

        return $this;
    }
}
