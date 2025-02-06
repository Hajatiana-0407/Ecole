<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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


        if ($form_niveau->isSubmitted() && $form_niveau->isValid()) {

            // ******************************************** //
            // dd($form_niveau->getData());
            // ******************************************** //

            $_niveau = $form_niveau->getData();
            $manager->persist($_niveau);
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


    #[Route('/niveau/edition/{id}', name: 'niveau_edit', methods: ['POST', 'GET'])]
    public function edition(
        Request $request,
        PaginatorInterface $paginator,
        EntityManagerInterface $manager,
        Niveau $niveau
    ): Response {

        $form_niveau = $this->createForm(NiveauType::class, $niveau);
        $form_niveau->handleRequest($request);

        if ($form_niveau->isSubmitted() && $form_niveau->isValid()) {
            $_niveau = $form_niveau->getData();
            $manager->persist($_niveau);
            $manager->flush();

            $this->addFlash('success', 'Mofdification éffectué');
            return $this->redirectToRoute('parametre_niveau');
        }

        $datas = $this->pagination($paginator, $request, $this->repository->__get_all());

        return $this->render('parametrage/niveau/index.html.twig', [
            ...$this->get_params(),
            'form_niveau' => $form_niveau->createView(),
            'datas' => $datas,
            'id' => $niveau->getId()
        ]);
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
