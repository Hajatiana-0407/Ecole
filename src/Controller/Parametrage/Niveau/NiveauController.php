<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Classe;
use App\Entity\Droit;
use App\Entity\Frais;
use App\Entity\Niveau;
use App\Entity\Search\SearchDate;
use App\Entity\SearchDateType;
use App\Form\NiveauType;
use App\Form\NiveauTypeEdit;
use App\Form\SearchDateType as FormSearchDateType;
use App\Repository\NiveauRepository;
use App\Service\EntityDeleteService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Attribute\Route as AttributeRoute;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/parametre', name: 'parametre_')]
class NiveauController extends NiveauParent
{
    protected $active_onglet;
    public function __construct(private NiveauRepository $repository)
    {
        parent::__construct();
        $this->active_onglet = 'Niveau';
    }

    /**
     * Ajout Niveau
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    #[Route('/niveau', name: 'niveau', methods: ['POST', 'GET'])]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        EntityManagerInterface $manager
    ): Response {
        $niveau  = new Niveau();
        $form_niveau = $this->createForm(NiveauType::class, $niveau);

        $form_niveau->handleRequest($request);


        /**
         * Creat a new level
         */
        if ($form_niveau->isSubmitted() && $form_niveau->isValid()) {

            $_niveau = $form_niveau->getData();
            $manager->persist($_niveau);

            // ******************** Frais de scolarité  ************************ //

            if (isset($_POST['niveau']['frais']) && isset($_POST['niveau']['frais']) > 0) {
                $frais = new Frais();
                $frais->setNiveau($_niveau)
                    ->setMontant($_POST['niveau']['frais']);
                $manager->persist($frais);
            }
            if (isset($_POST['niveau']['droit']) && isset($_POST['niveau']['droit']) > 0) {
                $droit = new Droit();
                $droit->setNiveau($_niveau)
                    ->setMontant($_POST['niveau']['droit']);
                $manager->persist($droit);
            }

            // ********************* Classes *********************** //

            if (isset($_POST['niveau']['nbr_classe']) && isset($_POST['niveau']['nbr_classe']) > 0) {
                if ($_POST['niveau']['nbr_classe'] == '') {
                    $_POST['niveau']['nbr_classe'] = 0;
                }
                $alphabets = range('A', 'Z');
                if ($_POST['niveau']['type'] == 'A') {
                    for ($i = $_POST['niveau']['nbr_classe'] - 1; $i >= 0; $i--) {
                        $classe = new Classe();
                        $classe->setDenomination($_POST['niveau']['nom'] . ' ' . $alphabets[$i])
                            ->setNiveau($_niveau);
                        $manager->persist($classe);
                    }
                } else {
                    for ($i = $_POST['niveau']['nbr_classe'] - 1; $i >= 0; $i--) {
                        $classe = new Classe();
                        $classe->setDenomination($_POST['niveau']['nom'] . ' ' . $i + 1)
                            ->setNiveau($_niveau);
                        $manager->persist($classe);
                    }
                }
            }
            // ********************************************************************** //

            $manager->flush();

            $this->addFlash('success', 'Ajout effectué');
            return $this->redirectToRoute('parametre_niveau');
        }

        // detection des erreur dans la formulaire et retourne dan le vue
        if ($form_niveau->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('parametrage/niveau/niveau_form_error.html.twig', [
                'form_niveau' => $form_niveau,
            ]);
        }


        $saerch = new SearchDate();
        $form_search = $this->createForm(FormSearchDateType::class, $saerch);
        $form_search->handleRequest( $request ) ; 

        $datas = $this->pagination($paginator, $request, $this->repository->__get_all( $saerch ));
        return $this->render('parametrage/niveau/index.html.twig', [
            ...$this->get_params(),
            'form_niveau' => $form_niveau->createView(),
            'form_search' => $form_search->createView(),
            'datas' => $datas,
        ]);
    }

    #[Route('/niveau/edition/{id}', name: 'niveau_edit', methods: ['POST', 'GET'])]
    /**
     * edition
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Niveau $niveau
     * @return Response
     */
    public function edition(
        Request $request,
        EntityManagerInterface $manager,
        Niveau $niveau
    ): Response {
        $form = $this->createForm(NiveauTypeEdit::class, $niveau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $manager->persist($data);
            $manager->flush();

            $this->addFlash('success', 'Modification éffetué');

            return $this->redirectToRoute('parametre_niveau');
        }

        if ($form->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form,
                'title' => 'Modification Niveau'
            ]);
        }


        return $this->render('partials/edition/edit_stream.html.twig', [
            ...$this->get_params(),
            'form' => $form,
            'annule_path' => 'parametre_niveau'
        ]);
    }
    #[Route('/niveau/edit/{id}', name: 'niveau_valid_edition', methods: ['POST', 'GET'])]
    public function edit(
        EntityManagerInterface $manager,
        Request $request,
        int $id
    ): Response {
        $niveau = new Niveau();
        $form = $this->createForm(NiveauTypeEdit::class, $niveau);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data->id);
            $data->setId($id);
            $manager->persist($data);
            $manager->flush();
        }

        return $this->redirectToRoute('parametre_niveau');
    }

    #[Route('/niveau/delete/{id}', name: 'niveau_delete', methods: ['POST', 'GET'])]
    /**
     * delete
     *
     * @param Niveau $niveau
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param integer $id
     * @return void
     */
    public function delete(Niveau $niveau, EntityManagerInterface $manager, Request $request, int $id, EntityDeleteService $delete)
    {
        return $delete->deleteEntity($niveau, $request, 'parametre_niveau', $id);
    }


    #[Route('niveau/search', name: 'niveau_search', methods: ['POST', 'GET'])]
    public function search() {}
}
