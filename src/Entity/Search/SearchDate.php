<?php 
namespace App\Entity\Search ;

use DateTimeInterface;

class SearchDate {
    private ? string $recherche = '' ; 
    private ? DateTimeInterface $dateDebut = null ; 
    private ? DateTimeInterface $dateFin = null  ; 

 

    /**
     * Get the value of dateDebut
     */ 
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of dateDebut
     *
     * @return  self
     */ 
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get the value of dateFin
     */ 
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set the value of dateFin
     *
     * @return  self
     */ 
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get the value of recherche
     */ 
    public function getRecherche()
    {
        return $this->recherche;
    }

    /**
     * Set the value of recherche
     *
     * @return  self
     */ 
    public function setRecherche($recherche)
    {
        $this->recherche = $recherche;

        return $this;
    }
}