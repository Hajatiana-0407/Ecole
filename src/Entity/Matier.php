<?php

namespace App\Entity;

use App\Repository\MatierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatierRepository::class)]
class Matier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $denomination = null;

    /**
     * @var Collection<int, MatierNiveau>
     */
    #[ORM\OneToMany(targetEntity: MatierNiveau::class, mappedBy: 'matier')]
    private Collection $matierNiveaux;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviation = null;

    public function __construct()
    {
        $this->matierNiveaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): static
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * @return Collection<int, MatierNiveau>
     */
    public function getMatierNiveaux(): Collection
    {
        return $this->matierNiveaux;
    }

    public function addMatierNiveau(MatierNiveau $matierNiveau): static
    {
        if (!$this->matierNiveaux->contains($matierNiveau)) {
            $this->matierNiveaux->add($matierNiveau);
            $matierNiveau->setMatier($this);
        }

        return $this;
    }

    public function removeMatierNiveau(MatierNiveau $matierNiveau): static
    {
        if ($this->matierNiveaux->removeElement($matierNiveau)) {
            // set the owning side to null (unless already changed)
            if ($matierNiveau->getMatier() === $this) {
                $matierNiveau->setMatier(null);
            }
        }

        return $this;
    }

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): static
    {
        $this->abreviation = $abreviation;

        return $this;
    }

}
