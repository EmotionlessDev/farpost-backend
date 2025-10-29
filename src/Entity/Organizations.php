<?php

namespace App\Entity;

use App\Repository\OrganizationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganizationsRepository::class)]
class Organizations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Blackout>
     */
    #[ORM\OneToMany(targetEntity: Blackout::class, mappedBy: 'organization')]
    private Collection $blackouts;

    public function __construct()
    {
        $this->blackouts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $blackout->setOrganization($this);
        }

        return $this;
    }

    public function removeBlackout(Blackout $blackout): static
    {
        if ($this->blackouts->removeElement($blackout)) {
            // set the owning side to null (unless already changed)
            if ($blackout->getOrganization() === $this) {
                $blackout->setOrganization(null);
            }
        }

        return $this;
    }
}
