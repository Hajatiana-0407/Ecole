<?php
namespace App\Entity\Search ; 
class Search {
    private ? string $recherche = '' ; 

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