<?php

namespace App\Controller\Parametrage\Matiere;

use App\Entity\MatiereNiveau;
use App\Form\CoeficientEdit;
use App\Form\MatNiveauType;
use App\Form\MatNiveauTypeAdd;
use App\Repository\MatiereNiveauRepository;
use App\Repository\MatiereRepository;
use App\Repository\NiveauRepository;
use App\Service\EntityDeleteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/parametre', name: 'parametre_')]
class MatiereNiveauController extends MatiereParent
{
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet = 'Niveau et Coeficient';
    }
    #[Route('/Matiere/coeficient', name: 'Matiere_coeficient')]
    public function index(
        Request $request,
        MatiereNiveauRepository $repository,
        MatiereRepository $MatiereRepository
    ): Response {
        $MatiereNiveau = new MatiereNiveau();
        $Matiere = $MatiereRepository->findOneBy([]);

        // le formulaire ne contient pas de Matieres / solution
        $MatiereNiveau->setMatiere($Matiere);

        // formulaire de recherche
        $form =  $this->createForm(MatNiveauType::class, $MatiereNiveau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $niveau = $form->getData()->getNiveau();
            $Matieres = $repository->__get_AllMat_by_niveau($niveau->getId());
            if ($request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                $MatiereNiveau->setNiveau($niveau);

                //  formulaire d'ajout 
                $form_add = $this->createForm(MatNiveauTypeAdd::class, $MatiereNiveau, [
                    'action' => $this->generateUrl('parametre_coeficient_addMatiere'),
                    'method' => 'POST',
                    'Matieres' => $Matieres
                ]);

                return $this->render('parametrage/Matiere/Matiere_tab_stream.html.twig', [
                    'datas' => $Matieres,
                    'niveau_id' => $niveau->getId(),
                    'niveau_nom' => $niveau->getNom(),
                    'form_add' => $form_add->createView(),
                    'add' => false
                ]);
            }
        }

        return $this->render('parametrage/Matiere/coeficient.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'js' => 'coeficient',
            'datas' => [],
        ]);
    }

    #[Route('/Matiere/coeficient/ajout', name: 'coeficient_addMatiere')]
    public function addMatiere(
        Request $request,
        EntityManagerInterface $manager,
        MatiereNiveauRepository $repository,
        NiveauRepository $niveauRepos,
    ) {
        $MatiereNiveau = new MatiereNiveau();
        $niveau = $niveauRepos->findOneBy([]);
        $MatiereNiveau->setNiveau($niveau);
        $form_add = $this->createForm(MatNiveauTypeAdd::class, $MatiereNiveau);
        $form_add->handleRequest($request);
        if ($form_add->isValid() && $form_add->isSubmitted()) {
            if ($request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                $niveau_id = 0;
                if (isset($_POST['__niveau_id'])) {
                    $niveau_id = trim(strip_tags($_POST['__niveau_id']));
                }
                $niveau_nom = '';
                if (isset($_POST['__niveau_nom'])) {
                    $niveau_nom = trim(strip_tags($_POST['__niveau_nom']));
                }

                $data = $form_add->getData();
                $niveau = $niveauRepos->find($niveau_id);

                $data->setNiveau($niveau);
                $manager->persist($data);
                $manager->flush();

                $Matieres = $repository->__get_AllMat_by_niveau($niveau_id);

                $MatiereNiveau = new MatiereNiveau();
                $MatiereNiveau->setNiveau($niveau);
                $form_add = $this->createForm(MatNiveauTypeAdd::class, $MatiereNiveau, [
                    'action' => $this->generateUrl('parametre_coeficient_addMatiere'),
                    'method' => 'POST',
                    'Matieres' => $Matieres
                ]);

                return $this->render('parametrage/Matiere/Matiere_tab_stream.html.twig', [
                    'datas' => $Matieres,
                    'niveau_id' => $niveau_id,
                    'niveau_nom' => $niveau_nom,
                    'form_add' => $form_add->createView(),
                    'add' => true
                ]);
            }
        }

        if ($request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form_add,
                'title' => 'Ajouter une nouvelle matière'
            ]);
        }

        $form =  $this->createForm(MatNiveauType::class, $MatiereNiveau);
        return $this->render('parametrage/Matiere/coeficient.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'js' => 'coeficient',
            'datas' => [],
        ]);
    }

    #[Route('/Matiere/coeficient/edition/{id}', name: 'coeficient_edit', methods: ['POST', 'GET'])]
    public function edition(
        Request $request,
        EntityManagerInterface $manager,
        MatiereNiveau $matiereNiveau,
        NiveauRepository $niveauRepos,
        MatiereNiveauRepository $repository,
        int $id
    ): Response {
        if (!$matiereNiveau) {
            $this->addFlash('danger', 'erreur');
            $this->redirectToRoute('parametre_Matiere_coeficient');
        }
        $niveau = $niveauRepos->find($matiereNiveau->getNiveau()->getId());
        $matieres = $repository->__get_AllMat_by_niveau($niveau->getId());;

        $form = $this->createForm(CoeficientEdit::class, $matiereNiveau, [
            'action' => $this->generateUrl('parametre_coeficient_edit_submit', [
                'id' => $id
            ]),
            'method' => 'POST',
        ]);
        if ($request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('parametrage/Matiere/Matiere_tab_stream.html.twig', [
                'datas' => $matieres,
                'niveau_id' => $niveau->getId(),
                'niveau_nom' => $niveau->getNom(),
                'form_add' => $form->createView(),
                'update' => true
            ]);
        }

        return $this->render('partials/Edition/edit_stream.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'annule_path' => 'parametre_classe'
        ]);
    }

    #[Route('/Matiere/coeficient/edition-sub/{id}', name: 'coeficient_edit_submit', methods: ['POST'])]
    public function editSubmit(
        Request $request,
        EntityManagerInterface $manager,
        MatiereNiveauRepository $repository,
        int $id
    ) {
        if (!$id) {
            return $this->redirectToRoute('parametre_Matiere_coeficient');
        }

        $matiereNiveau = $repository->find($id);
        $form = $this->createForm(CoeficientEdit::class, $matiereNiveau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $manager->persist($data);
            $manager->flush();

            $niveau = $data->getNiveau() ; 

            //  retourner a l'etat de l'ajout $niveau = $form->getData()->getNiveau();
            $Matieres = $repository->__get_AllMat_by_niveau($niveau->getId());


            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            $matiereNiveau = new MatiereNiveau() ; 
            $matiereNiveau->setNiveau($niveau);

            //  formulaire d'ajout 
            $form_add = $this->createForm(MatNiveauTypeAdd::class, $matiereNiveau, [
                'action' => $this->generateUrl('parametre_coeficient_addMatiere'),
                'method' => 'POST',
                'Matieres' => $Matieres
            ]);

            return $this->render('parametrage/Matiere/Matiere_tab_stream.html.twig', [
                'datas' => $Matieres,
                'niveau_id' => $niveau->getId(),
                'niveau_nom' => $niveau->getNom(),
                'form_add' => $form_add->createView(),
                'updated' => true 
            ]);
        } else {
            // return $this->redirect('') ; 
        }
    }


    #[Route('/matiere/coeficient/delete/{id}' , name : 'coeficient_delete' , methods:['post' , 'get'])]
    public function delete(MatiereNiveau $matNiveau , EntityManagerInterface $manager, Request $request, int $id , EntityDeleteService $delete )
    {
        return $delete->deleteEntity( $matNiveau  , $request , 'parametre_niveau' , $id ) ; 
    }
	
}
