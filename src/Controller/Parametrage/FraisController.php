<?php

namespace App\Controller\Parametrage;

use App\Controller\Parametrage\ParametrageController;
use App\Entity\Classe;
use App\Entity\Frais;
use App\Form\ClasseType;
use App\Form\FraisType;
use App\Repository\ClasseRepository;
use App\Repository\FraisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class FraisController extends ParametrageController
{
    public function __construct()
    {
        parent::__construct();
        $this->active_class = 'Frais de scolarité';
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


    public function get_params(): array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste($this->active_class),
            'js' => 'frais'
        ];
    }
}
