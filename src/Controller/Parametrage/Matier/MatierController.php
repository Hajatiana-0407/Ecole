<?php

namespace App\Controller\Parametrage\Matier;

use App\Entity\Matier;
use App\Form\MatierType;
use App\Repository\MatierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/parametre', name: 'parametre_')]
class MatierController extends MatierParent 
{
    public function __construct( private MatierRepository $repository )
    {
        parent::__construct();
        $this->active_onglet = 'Ajout' ; 
    }

    #[Route('/matier', name: 'matier')]
    public function index(
        Request $request,
        EntityManagerInterface $manger,
        MatierRepository $matierrepos,
        PaginatorInterface $paginator
    ): Response {
        $matier = new Matier();
        $form = $this->createForm(MatierType::class, $matier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $manger->persist($data);
            $manger->flush();


            $this->addFlash('success', 'Ajout effectué');
            return $this->redirectToRoute('parametre_matier');
        }

        $datas = $this->pagination($paginator, $request, $matierrepos->__get_all());


        return $this->render('parametrage/matier/matier.html.twig', [
            ...$this->get_params(),
            'js' => 'matiere' , 
            'form_matier' => $form->createView(),
            'datas' => $datas
        ]);
    }

    #[Route('/matiere/ajaxdata/{id}', name: 'ajaxdata_matiere', methods: ['POST'])]
    public function ajaxdata(
        Request $request,
        Matier $matier
    ): JsonResponse {
        return new JsonResponse([
            'id' => $matier->getId(),
            'denomination' => $matier->getDenomination(),
            'abreviation' => $matier->getAbreviation()
        ]);
    }


    #[Route('/matiere/edition/{id}', name: 'matiere_edit', methods: ['POST'])]
    public function edition(
        EntityManagerInterface $manager,
        CsrfTokenManagerInterface $csrftoken,
        Request $request,
        Int $id,
    ): Response {
        $matiere =  $this->repository->find($id);
        $token = $request->request->get('_token');
        if ($csrftoken->isTokenValid(new CsrfToken('form_niveau_edit', $token))) {
            $matiere->setDenomination($request->request->get('denomination'));
            $matiere->setAbreviation($request->request->get('abreviation'));
            $manager->persist($matiere);
            $manager->flush();
            $this->addFlash('success', 'Mofdification éffectué');
            return $this->redirectToRoute('parametre_matier');
        }
        $this->addFlash('danger', 'Une erreur c\'est produite');
        return $this->redirectToRoute('parametre_matier');
    }



    #[Route('/matiere/delete/{id}', name: 'matiere_delete', methods: ['POST', 'GET'])]
    public function delete(Matier $matiere, EntityManagerInterface $manager)
    {
        if (!$matiere) {
            $this->addFlash('danger', 'Erreu lors de la suppréssion');
            return new  Response(json_encode([
                'redirect' => $this->generateUrl('parametre_matier'),
            ]));
        }
        $manager->remove($matiere);
        $manager->flush();

        $this->addFlash('success', 'Suppression éffectué');
        return new  Response(json_encode([
            'redirect' => $this->generateUrl('parametre_matier'),
        ]));
    }
}
