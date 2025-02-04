<?php

namespace App\Controller;

use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eleve', name: 'eleve_')]
class BaseController extends AbstractController
{
    public function pagination( PaginatorInterface $paginator , Request $request , Query $query ){
        $limite = 12 ; 
        return $paginator->paginate( $query  , $request->query->getInt('page' , 1 ) ,  $limite  ) ; 
    }
}
