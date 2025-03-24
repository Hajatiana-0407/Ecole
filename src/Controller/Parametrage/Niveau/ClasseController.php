<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Classe;
use App\Entity\Search\Search;
use App\Form\ClasseType;
use App\Form\SearchType;
use App\Repository\ClasseRepository;
use App\Service\EntityDeleteService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/parametre', name: 'parametre_')]
class ClasseController extends NiveauParent
{
    protected $active_onglet;
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet = 'Classe';
    }

    #[Route('/niveau/classe', name: 'classe')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        ClasseRepository $repository,
        PaginatorInterface $paginator
    ): Response {
        $classe = new Classe();
        $classe_form = $this->createForm(ClasseType::class, $classe);
        $classe_form->handleRequest($request);
        if ($classe_form->isSubmitted() && $classe_form->isValid()) {
            $data = $classe_form->getData();
            $manager->persist($data);
            $manager->flush();

            $this->addFlash('success', 'Ajout éffectué');
            return $this->redirectToRoute('parametre_classe');
        }

        if ($request->getPreferredFormat() === TurboBundle::STREAM_FORMAT && $classe_form->isSubmitted()) {

            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $classe_form,
                'title' => 'Ajout Classe',

            ]);
        }

        $search = New Search() ; 
        $form_search = $this->createForm( SearchType::class , $search ) ; 
        $form_search->handleRequest( $request ) ; 

        $datas = $this->pagination($paginator, $request, $repository->__get_all( $search ));
        return $this->render('parametrage/niveau/classe.html.twig', [
            ...$this->get_params(),
            'classe_form' => $classe_form->createView(),
            'form_search' => $form_search->createView() , 
            'datas' => $datas
        ]);
    }

    #[Route('/niveau/classe/edition/{id}', name: 'classe_edit', methods: ['POST', 'GET'])]
    public function edition(
        Request $request,
        EntityManagerInterface $manager,
        Classe $classe
    ): Response {

        $classe_form = $this->createForm(ClasseType::class, $classe);
        $classe_form->handleRequest($request);
        if ($classe_form->isSubmitted() && $classe_form->isValid()) {
            $data = $classe_form->getData();
            $manager->persist($data);
            $manager->flush();

            $this->addFlash('success', 'Modification éffectué');
            $request->setRequestFormat('html');
            return $this->redirectToRoute('parametre_classe');
        }

        if ($classe_form->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $classe_form,
                'title' => 'Modification Classe'
            ]);
        }

        return $this->render('partials/Edition/edit_stream.html.twig', [
            ...$this->get_params(),
            'form' => $classe_form->createView(),
            'annule_path' => 'parametre_classe'
        ]);
    }

    #[Route('/niveau/classe/delete/{id}', name: 'classe_delete', methods: ['POST', 'GET'])]
    public function delete( Classe $classe,  Request $request,  EntityDeleteService $delete , int $id  )
    {
        return $delete->deleteEntity( $classe , $request , 'parametre_classe' , $id  ) ; 
    }
	
}
