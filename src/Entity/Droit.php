<?php

namespace App\Entity;

use App\Repository\DroitRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DroitRepository::class)]
class Droit
{
    public function __construct( )
    {
        $this->createdAt = new DateTimeImmutable() ; 
    }

    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\ManyToOne(inversedBy: 'droits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveau $Niveau = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->Niveau;
    }

    public function setNiveau(?Niveau $Niveau): static
    {
        $this->Niveau = $Niveau;

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
}
