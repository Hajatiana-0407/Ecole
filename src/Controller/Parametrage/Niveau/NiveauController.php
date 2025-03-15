<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Classe;
use App\Entity\Droit;
use App\Entity\Frais;
use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

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
                if ( $_POST['niveau']['nbr_classe'] == ''){
                    $_POST['niveau']['nbr_classe'] = 0 ; 
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

        $datas = $this->pagination($paginator, $request, $this->repository->__get_all());


        return $this->render('parametrage/niveau/index.html.twig', [
            ...$this->get_params(),
            'form_niveau' => $form_niveau->createView(),
            'datas' => $datas
        ]);
    }

    #[Route('/niveau/ajaxdata/{id}', name: 'ajaxdata', methods: ['POST'])]
    public function ajaxdata(
        Request $request,
        Niveau $niveau
    ): JsonResponse {
        return new JsonResponse([
            'id' => $niveau->getId(),
            'nom' => $niveau->getNom()
        ]);
    }

    #[Route('/niveau/edition/{id}', name: 'niveau_edit', methods: ['POST'])]
    public function edition(
        EntityManagerInterface $manager,
        CsrfTokenManagerInterface $csrftoken,
        Request $request , 
        Int $id , 
    ): Response {
        $niveau =  $this->repository->find($id) ; 
        $token = $request->request->get('_token');
        if ($csrftoken->isTokenValid(new CsrfToken('form_niveau_edit', $token))) { 
                $niveau->setNom($request->request->get('nom')) ; 
                $manager->persist( $niveau ) ; 
                $manager->flush() ; 
                $this->addFlash('success', 'Mofdification éffectué');
                return $this->redirectToRoute('parametre_niveau');
        }
        $this->addFlash('danger', 'Une erreur c\'est produite');
        return $this->redirectToRoute('parametre_niveau');
    }

    #[Route('/niveau/delete/{id}', name: 'niveau_delete', methods: ['POST', 'GET'])]
    public function delete(Niveau $niveau, EntityManagerInterface $manager)
    {
        if (!$niveau) {
            $this->addFlash('danger', 'Erreu lors de la suppréssion');
            return new  Response(json_encode([
                'redirect' => $this->generateUrl('parametre_niveau'),
            ]));
        }
        $manager->remove($niveau);
        $manager->flush();

        $this->addFlash('success', 'Suppression éffectué');
        return new  Response(json_encode([
            'redirect' => $this->generateUrl('parametre_niveau'),
        ]));
    }
}
