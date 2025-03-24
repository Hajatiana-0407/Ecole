<?php

namespace App\Controller\Parametrage\Matiere;

use App\Entity\Matiere;
use App\Entity\Search\Search;
use App\Form\MatiereType;
use App\Form\SearchType;
use App\Repository\MatiereRepository;
use App\Service\EntityDeleteService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/parametre', name: 'parametre_')]
class MatiereController extends MatiereParent
{
    public function __construct(private MatiereRepository $repository)
    {
        parent::__construct();
        $this->active_onglet = 'Ajout';
    }

    #[Route('/matiere', name: 'Matiere', methods: ['POST', 'GET'])]
    public function index(
        Request $request,
        EntityManagerInterface $manger,
        MatiereRepository $Matiererepos,
        PaginatorInterface $paginator
    ): Response {
        $Matiere = new Matiere();
        $form = $this->createForm(MatiereType::class, $Matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $manger->persist($data);
            $manger->flush();


            $this->addFlash('success', 'Ajout effectué');
            return $this->redirectToRoute('parametre_Matiere');
        }



        if ($form->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form,
                'title' => 'Ajout Matière'
            ]);
        }

        $search = new Search();
        $form_search = $this->createForm(SearchType::class, $search);
        $form_search->handleRequest($request);

        $datas = $this->pagination($paginator, $request, $Matiererepos->__get_all( $search ));
        return $this->render('parametrage/Matiere/Matiere.html.twig', [
            ...$this->get_params(),
            'js' => 'Matiere',
            'form_Matiere' => $form->createView(),
            'form_search' => $form_search , 
            'datas' => $datas
        ]);
    }

    #[Route('/matiere/edition/{id}', name: 'Matiere_edit', methods: ['GET', 'POST'])]
    public function edition(
        Request $request,
        EntityManagerInterface $manager,
        Matiere $Matiere
    ): Response {

        $form = $this->createForm(MatiereType::class, $Matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $manager->persist($data);
            $manager->flush();

            $this->addFlash('success', 'Modification éffectué');
            return $this->redirectToRoute('parametre_Matiere');
        }

        if ($form->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form,
                'title' => 'Modification Matière'
            ]);
        }

        return $this->render('partials/Edition/edit_stream.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'annule_path' => 'parametre_Matiere'
        ]);
    }



    #[Route('/matiere/delete/{id}', name: 'matiere_delete', methods: ['POST', 'GET'])]
    public function delete(Matiere $matiere, EntityManagerInterface $manager, Request $request, int $id, EntityDeleteService $delete)
    {
        return $delete->deleteEntity($matiere, $request, 'parametre_niveau', $id);
    }
}
