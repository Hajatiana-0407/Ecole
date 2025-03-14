<?php

namespace App\Controller\Parametrage\Frais;

use App\Entity\Frais;
use App\Form\FraisType;
use App\Repository\FraisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class FraisController extends FraisParent
{
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet = 'Ecolage';
    }

    #[Route('/frais', name: 'frais')]
    public function index(
        Request $request,
        EntityManagerInterface $manager , 
        FraisRepository $repository ,
        PaginatorInterface $paginator 
    ) {
        $frais = new Frais();
        $form_frais = $this->createForm(FraisType::class, $frais);
        $form_frais->handleRequest($request);
        if ($form_frais->isSubmitted() && $form_frais->isValid()) {
            $data = $form_frais->getData();
            $manager->persist($data);
            $manager->flush();
            $this->addFlash('success', 'Ajout effectué');
            return $this->redirectToRoute('parametre_frais');
        }

        $datas = $this->pagination( $paginator , $request , $repository->__get_all() ) ; 


        return $this->render('parametrage/frais/frais.html.twig', [
            ...$this->get_params(),
            'form' => $form_frais->createView() , 
            'datas' => $datas 
        ]);
    }

}
