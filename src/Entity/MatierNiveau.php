<?php

namespace App\Entity;

use App\Repository\MatierNiveauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MatierNiveauRepository::class)]
class MatierNiveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $coeficient = null;

    #[ORM\ManyToOne(inversedBy: 'matierNiveaux')]
    #[ORM\JoinColumn(nullable: false)] // ⚠️ Rend la colonne obligatoire en base de données
    #[Assert\NotNull(message: "Vous devez sélectionner une niveau.")]
    private ?Niveau $niveau ;

    #[ORM\ManyToOne(inversedBy: 'matierNiveaux')]
    #[ORM\JoinColumn(nullable: false)] // ⚠️ Rend la colonne obligatoire en base de données
    #[Assert\NotNull(message: "Vous devez sélectionner une matière.")]
    private ?Matier $matier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoeficient(): ?float
    {
        return $this->coeficient;
    }

    public function setCoeficient(float $coeficient): static
    {
        $this->coeficient = $coeficient;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getMatier(): ?Matier
    {
        return $this->matier;
    }

    public function setMatier(?Matier $matier): static
    {
        $this->matier = $matier;

        return $this;
    }
}
