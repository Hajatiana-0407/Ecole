<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

        $datas = $this->pagination($paginator, $request, $repository->__get_all());


        return $this->render('parametrage/niveau/classe.html.twig', [
            ...$this->get_params(),
            'classe_form' => $classe_form->createView(),
            'datas' => $datas
        ]);
    }

    #[Route('/niveau/classe/edition/{id}', name: 'classe_edit', methods: ['POST', 'GET'])]
    public function edition(
        Request $request,
        EntityManagerInterface $manager,
        ClasseRepository $repository,
        PaginatorInterface $paginator,
        Classe $classe
    ): Response {
        $classe_form = $this->createForm(ClasseType::class, $classe);
        $classe_form->handleRequest($request);
        if ($classe_form->isSubmitted() && $classe_form->isValid()) {
            $data = $classe_form->getData();
            $manager->persist($data);
            $manager->flush();

            $this->addFlash('success', 'Modification éffectué');
            return $this->redirectToRoute('parametre_classe');
        }

        $datas = $this->pagination($paginator, $request, $repository->__get_all());


        return $this->render('parametrage/niveau/classe.html.twig', [
            ...$this->get_params(),
            'classe_form' => $classe_form->createView(),
            'datas' => $datas,
            'id' => $classe->getId()
        ]);
    }

    #[Route('/niveau/classe/delete/{id}', name: 'classe_delete', methods: ['POST', 'GET'])]
    public function delete(Classe $classe, EntityManagerInterface $manager)
    {
        if (!$classe) {
            $this->addFlash('danger', 'Erreu lors de la suppréssion');
            return new  Response(json_encode([
                'redirect' => $this->generateUrl('parametre_classe'),
            ]));
        }
        $manager->remove($classe);
        $manager->flush();

        $this->addFlash('success', 'Suppression éffectué');
        return new  Response(json_encode([
            'redirect' => $this->generateUrl('parametre_classe'),
        ]));
    }
}
