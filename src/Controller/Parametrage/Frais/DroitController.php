<?php

namespace App\Controller\Parametrage\Frais;

use App\Entity\Droit;
use App\Form\DroitType;
use App\Repository\DroitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/parametre', name: 'parametre_')]
class DroitController extends FraisParent
{
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet = 'Droit d\'inscription';
    }

    #[Route('/droit', name: 'droit')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        DroitRepository $repository,
        PaginatorInterface $paginator
    ) {
        $droit = new Droit();
        $form_droit = $this->createForm(DroitType::class, $droit);
        $form_droit->handleRequest($request);
        if ($form_droit->isSubmitted() && $form_droit->isValid()) {
            $data = $form_droit->getData();
            $manager->persist($data);
            $manager->flush();
            $this->addFlash('success', 'Ajout effectué');
            return $this->redirectToRoute('parametre_droit');
        }


        $datas = $this->pagination($paginator, $request, $repository->__get_all());

        if ($form_droit->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form_droit,
                'title' => 'Droit d\'inscription'
            ]);
        }


        return $this->render('parametrage/frais/droit.html.twig', [
            ...$this->get_params(),
            'form' => $form_droit->createView(),
            'datas' => $datas
        ]);
    }
}
