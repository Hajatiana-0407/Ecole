<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
#[UniqueEntity(fields: ['nom'], message: 'Ce nom existe déjà. Veuillez en choisir un autre.')]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Classe::class, mappedBy: 'Niveau', orphanRemoval: true)]
    private Collection $classes;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Frais>
     */
    #[ORM\OneToMany(targetEntity: Frais::class, mappedBy: 'Niveau', orphanRemoval: true)]
    private Collection $frais;

    /**
     * @var Collection<int, Droit>
     */
    #[ORM\OneToMany(targetEntity: Droit::class, mappedBy: 'Niveau')]
    private Collection $droits;

    /**
     * @var Collection<int, MatierNiveau>
     */
    #[ORM\OneToMany(targetEntity: MatierNiveau::class, mappedBy: 'niveau')]
    private Collection $matierNiveaux;


    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->frais = new ArrayCollection();
        $this->droits = new ArrayCollection();
        $this->matierNiveaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setNiveau($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): static
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getNiveau() === $this) {
                $class->setNiveau(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function ___toString(): string
    {
        return $this->getNom();
    }

    /**
     * @return Collection<int, Frais>
     */
    public function getFrais(): Collection
    {
        return $this->frais;
    }

    public function addFrai(Frais $frai): static
    {
        if (!$this->frais->contains($frai)) {
            $this->frais->add($frai);
            $frai->setNiveau($this);
        }

        return $this;
    }

    public function removeFrai(Frais $frai): static
    {
        if ($this->frais->removeElement($frai)) {
            // set the owning side to null (unless already changed)
            if ($frai->getNiveau() === $this) {
                $frai->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Droit>
     */
    public function getDroits(): Collection
    {
        return $this->droits;
    }

    public function addDroit(Droit $droit): static
    {
        if (!$this->droits->contains($droit)) {
            $this->droits->add($droit);
            $droit->setNiveau($this);
        }

        return $this;
    }

    public function removeDroit(Droit $droit): static
    {
        if ($this->droits->removeElement($droit)) {
            // set the owning side to null (unless already changed)
            if ($droit->getNiveau() === $this) {
                $droit->setNiveau(null);
            }
        }

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
            $matierNiveau->setNiveau($this);
        }

        return $this;
    }

    public function removeMatierNiveau(MatierNiveau $matierNiveau): static
    {
        if ($this->matierNiveaux->removeElement($matierNiveau)) {
            // set the owning side to null (unless already changed)
            if ($matierNiveau->getNiveau() === $this) {
                $matierNiveau->setNiveau(null);
            }
        }

        return $this;
    }

    
}
