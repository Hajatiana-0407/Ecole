<?php

namespace App\Controller\Parametrage\Matiere;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
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

    #[Route('/Matiere', name: 'Matiere', methods: ['POST', 'GET'])]
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

        $datas = $this->pagination($paginator, $request, $Matiererepos->__get_all());

        if ($form->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form,
                'title' => 'Ajout Matière'
            ]);
        }


        return $this->render('parametrage/Matiere/Matiere.html.twig', [
            ...$this->get_params(),
            'js' => 'Matiere',
            'form_Matiere' => $form->createView(),
            'datas' => $datas
        ]);
    }

    #[Route('/Matiere/edition/{id}', name: 'Matiere_edit', methods: ['GET', 'POST'])]
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



    #[Route('/Matiere/delete/{id}', name: 'Matiere_delete', methods: ['POST', 'GET'])]
    public function delete(Matiere $Matiere, EntityManagerInterface $manager)
    {
        if (!$Matiere) {
            $this->addFlash('danger', 'Erreu lors de la suppréssion');
            return new  Response(json_encode([
                'redirect' => $this->generateUrl('parametre_Matiere'),
            ]));
        }
        $manager->remove($Matiere);
        $manager->flush();

        $this->addFlash('success', 'Suppression éffectué');
        return $this->redirectToRoute('parametre_Matiere');
    }
}
