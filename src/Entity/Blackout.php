<?php

namespace App\Entity;

use App\Enum\BlackoutType;
use App\Repository\BlackoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlackoutRepository::class)]
class Blackout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $start_date = null;

    #[ORM\Column(type: 'datetime', nullable: true)]

    private ?\DateTime $end_date = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(enumType: BlackoutType::class)]
    private ?BlackoutType $type = null;

    #[ORM\Column(length: 255)]
    private ?string $initiator_name = null;

    #[ORM\Column(length: 255)]
    private ?string $source = null;

    /**
     * @var Collection<int, Building>
     */
    #[ORM\ManyToMany(targetEntity: Building::class, inversedBy: 'blackouts')]
    private Collection $�building;

    public function __construct()
    {
        $this->�building = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTime $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?BlackoutType
    {
        return $this->type;
    }

    public function setType(BlackoutType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getInitiatorName(): ?string
    {
        return $this->initiator_name;
    }

    public function setInitiatorName(string $initiator_name): static
    {
        $this->initiator_name = $initiator_name;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return Collection<int, Building>
     */
    public function get�building(): Collection
    {
        return $this->�building;
    }

    public function addBuilding(Building $building): static
    {
        if (!$this->�building->contains($building)) {
            $this->�building->add($building);
        }

        return $this;
    }

    public function removeBuilding(Building $building): static
    {
        $this->�building->removeElement($building);

        return $this;
    }
}
