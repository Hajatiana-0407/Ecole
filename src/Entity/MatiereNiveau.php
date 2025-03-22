<?php

namespace App\Entity;

use App\Repository\MatiereNiveauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MatiereNiveauRepository::class)]
class MatiereNiveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $coeficient = null;

    #[ORM\ManyToOne(inversedBy: 'MatiereNiveaux')]
    #[ORM\JoinColumn(nullable: false)] // ⚠️ Rend la colonne obligatoire en base de données
    #[Assert\NotNull(message: "Vous devez sélectionner une niveau.")]
    private ?Niveau $niveau ;

    #[ORM\ManyToOne(inversedBy: 'MatiereNiveaux')]
    #[ORM\JoinColumn(nullable: false)] // ⚠️ Rend la colonne obligatoire en base de données
    #[Assert\NotNull(message: "Vous devez sélectionner une matière.")]
    private ?Matiere $Matiere = null;

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

    public function getMatiere(): ?Matiere
    {
        return $this->Matiere;
    }

    public function setMatiere(?Matiere $Matiere): static
    {
        $this->Matiere = $Matiere;

        return $this;
    }
}
