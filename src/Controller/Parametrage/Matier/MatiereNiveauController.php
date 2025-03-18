<?php

namespace App\Controller\Parametrage\Matier;

use App\Entity\MatierNiveau;
use App\Form\MatNiveauType;
use App\Form\MatNiveauTypeAdd;
use App\Form\NiveauAutocompleteField;
use App\Repository\MatierNiveauRepository;
use App\Repository\MatierRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/parametre', name: 'parametre_')]
class MatiereNiveauController extends MatierParent
{
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet = 'Niveau et Coeficient';
    }
    #[Route('/matiere/coeficient', name: 'matiere_coeficient')]
    public function index(
        Request $request,
        MatierNiveauRepository $repository,
        MatierRepository $matiereRepository
    ): Response {
        $matierNiveau = new MatierNiveau();
        $matiere = $matiereRepository->findOneBy([]);

        $matierNiveau->setMatier($matiere);

        // formulaire de recherche
        $form =  $this->createForm(MatNiveauType::class, $matierNiveau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $niveau = $form->getData()->getNiveau();
            $matiers = $repository->__get_AllMat_by_niveau($niveau->getId());
            if ($request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                $matierNiveau->setNiveau($niveau);

                //  formulaire d'ajout 
                $form_add = $this->createForm(MatNiveauTypeAdd::class, $matierNiveau, [
                    'action' => $this->generateUrl('parametre_coeficient_addmatiere'),
                    'method' => 'POST',
                    'matieres' => $matiers
                ]);

                return $this->render('parametrage/matier/matiere_tab_stream.html.twig', [
                    'datas' => $matiers,
                    'niveau_id' => $niveau->getId(),
                    'niveau_nom' => $niveau->getNom(),
                    'form_add' => $form_add->createView(),
                    'add' => false
                ]);
            }
        }

        return $this->render('parametrage/matier/coeficient.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'js' => 'coeficient',
            'datas' => [],
        ]);
    }

    #[Route('/matiere/coeficient/ajout', name: 'coeficient_addmatiere')]
    public function addmatiere(
        Request $request,
        EntityManagerInterface $manager,
        MatierNiveauRepository $repository,
        NiveauRepository $niveauRepos,
    ) {
        $matierNiveau = new MatierNiveau();
        $niveau = $niveauRepos->findOneBy([]);
        $matierNiveau->setNiveau($niveau);
        $form_add = $this->createForm(MatNiveauTypeAdd::class, $matierNiveau);
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

                $matiers = $repository->__get_AllMat_by_niveau($niveau_id);

                $matierNiveau = new MatierNiveau();
                $matierNiveau->setNiveau($niveau);
                $form_add = $this->createForm(MatNiveauTypeAdd::class, $matierNiveau, [
                    'action' => $this->generateUrl('parametre_coeficient_addmatiere'),
                    'method' => 'POST',
                    'matieres' => $matiers
                ]);

                return $this->render('parametrage/matier/matiere_tab_stream.html.twig', [
                    'datas' => $matiers,
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
                'form' => $form_add ,
		        'title' => 'Ajouter une nouvelle matière'
            ]);
        }

        $form =  $this->createForm(MatNiveauType::class, $matierNiveau);
        return $this->render('parametrage/matier/coeficient.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'js' => 'coeficient',
            'datas' => [],
        ]);
    }
}
