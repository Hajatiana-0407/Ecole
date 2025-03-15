<?php

namespace App\Controller\Parametrage\Matier;

use App\Repository\MatierNiveauRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/parametre', name: 'parametre_')]
class MatiereNiveau extends MatierParent
{
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet = 'Niveau et Coeficient';
    }
    #[Route('/matiere/coeficient', name: 'matiere_coeficient')]
    public function index(
        Request $request,
        EntityManagerInterface $manger,
        MatierNiveauRepository $repository,
        NiveauRepository $Niveaurepository,
        PaginatorInterface $paginator
    ): Response {

        $niveaux  = $Niveaurepository->getAllNiveau();
        return $this->render('parametrage/matier/coeficient.html.twig', [
            ...$this->get_params(),
            'niveaux' => $niveaux,
            'js' => 'coeficient',
        ]);
    }

    #[Route('/matiere/srch_niveau', name: 'srch_niveau')]
    public function search(
        Request $request,
        EntityManagerInterface $manger,
        MatierNiveauRepository $repository,
        NiveauRepository $Niveaurepository,
        PaginatorInterface $paginator,
        CsrfTokenManagerInterface $Csrftoken,
    ) {
        $niveau = $request->request->get('niveau');
        $token = $request->request->get('_token');
        if (!$Csrftoken->isTokenValid(new CsrfToken('srch_niveau', $token))) {
            return $this->redirectToRoute('app_login');
        }
        $matiers = $repository->__get_AllMat_by_niveau($niveau);

        return $this->render('parametrage/matier/coeficient.html.twig', [
            ...$this->get_params(),
            'niveaux' => $Niveaurepository->getAllNiveau() ,
            'js' => 'coeficient',
            'datas' => $matiers ,
        ]);
    }
}
