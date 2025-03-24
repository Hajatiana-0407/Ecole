<?php

namespace App\Controller\Parametrage\Frais;

use App\Entity\Frais;
use App\Entity\Search\Search;
use App\Form\FraisType;
use App\Form\SearchType;
use App\Repository\FraisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

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
        EntityManagerInterface $manager,
        FraisRepository $repository,
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

        
        if ( $form_frais->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form_frais,
                'title' => 'Ajout Frais'
            ]);
        }

        $search = new Search();
        $form_search = $this->createForm(SearchType::class, $search);
        $form_search->handleRequest($request);
        
        
        $datas = $this->pagination($paginator, $request, $repository->__get_all( $search ));
        return $this->render('parametrage/frais/frais.html.twig', [
            ...$this->get_params(),
            'form' => $form_frais->createView(),
            'form_search' => $form_search , 
            'datas' => $datas
        ]);
    }
}
