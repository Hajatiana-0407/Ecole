<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
#[UniqueEntity(fields:'denomination' , message:'Ce denomination existe déjà.')]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $denomination = null;

    /**
     * @var Collection<int, MatiereNiveau>
     */
    #[ORM\OneToMany(targetEntity: MatiereNiveau::class, mappedBy: 'Matiere')]
    private Collection $MatiereNiveaux;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviation = null;

    public function __construct()
    {
        $this->MatiereNiveaux = new ArrayCollection();
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
     * @return Collection<int, MatiereNiveau>
     */
    public function getMatiereNiveaux(): Collection
    {
        return $this->MatiereNiveaux;
    }

    public function addMatiereNiveau(MatiereNiveau $MatiereNiveau): static
    {
        if (!$this->MatiereNiveaux->contains($MatiereNiveau)) {
            $this->MatiereNiveaux->add($MatiereNiveau);
            $MatiereNiveau->setMatiere($this);
        }

        return $this;
    }

    public function removeMatiereNiveau(MatiereNiveau $MatiereNiveau): static
    {
        if ($this->MatiereNiveaux->removeElement($MatiereNiveau)) {
            // set the owning side to null (unless already changed)
            if ($MatiereNiveau->getMatiere() === $this) {
                $MatiereNiveau->setMatiere(null);
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
