<?php 
namespace App\Search\Parametrage ; 

class SearchDateType {
    private string $mot_cle = '' ; 
    private  $date_debut = '' ; 
    private  $date_fin = '' ; 

    /**
     * geter mot cle 
     *
     * @return string
     */
    public function  getMot_cle() : string 
    {
        return $this->mot_cle ;
    }
    /**
     * geter date debut  
     *
     * @return string
     */
    public function  getDate_debut()  
    {
        return $this->date_debut ;
    }
    /**
     * geter date fin  
     *
     * @return string
     */
    public function  getDate_fin()  
    {
        return $this->date_fin ;
    }
}