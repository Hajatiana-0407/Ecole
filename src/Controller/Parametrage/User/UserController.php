<?php

namespace App\Controller\Parametrage\User;

use App\Controller\Parametrage\ParametrageController;
use App\Entity\Search\Search;
use App\Entity\User;
use App\Form\SearchType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\EntityDeleteService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/parametre', name: 'parametre_')]
class UserController extends ParametrageController
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct();
        $this->active_class = 'Utilisateur';
    }


    private function get_params(): array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste($this->active_class),
        ];
    }

    #[Route('/utilisateur', name: 'utilisateur')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        UserRepository $repository,
        PaginatorInterface $paginator
    ): Response {
        $User = new User();
        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $User->setPhoto('');
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $newFilename = uniqid() . '.' . $photo->guessExtension();

                try {
                    // Déplacer le fichier vers le dossier configuré
                    $photo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );

                    // Enregistrer le nom de l'image dans l'entité
                    $User->setPhoto($this->getParameter('images_directory') . '/' . $newFilename);
                } catch (FileException $e) {
                    // Gérer les erreurs si besoin
                    $this->addFlash('danger', 'Erreur lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('parametre_utilisateur');
                }
            }

            $passwordhashed = $this->userPasswordHasher->hashPassword($User, $this->getParameter('default_pass'));
            $User->setPassword($passwordhashed);
            $data = $form->getData();
            $manager->persist($data);
            $manager->flush();


            $this->addFlash('success', 'Ajout éffectué');
            return $this->redirectToRoute('parametre_utilisateur');
        }

        if ($request->getPreferredFormat() === TurboBundle::STREAM_FORMAT && $form->isSubmitted()) {

            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('parametrage/utilisateur/utilisateur_error.html.twig', [
                'form' => $form,
            ]);
        }

        $search = new Search();
        $form_search = $this->createForm(SearchType::class, $search);
        $form_search->handleRequest($request);

        $datas = $this->pagination($paginator, $request, $repository->__get_all($search));

        return $this->render('parametrage/utilisateur/utilisateur.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'form_search' => $form_search->createView(),
            'datas' => $datas
        ]);
    }

    #[Route('/utilisateur/edition/{id}', name: 'user_edit', methods: ['POST', 'GET'])]
    public function edition(
        Request $request,
        EntityManagerInterface $manager,
        User $user
    ): Response {
        $photo_directory = '';
        if ($user) {
            $photo_directory = $user->getPhoto();
        }

        $user->setPhoto(null);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPhoto( $photo_directory );
            $photo = $form->get('photo')->getData();

            if ($photo) {
                $newFilename = uniqid() . '.' . $photo->guessExtension();

                try {
                    // Déplacer le fichier vers le dossier configuré
                    $photo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );

                    // Enregistrer le nom de l'image dans l'entité
                    $user->setPhoto($this->getParameter('images_directory') . '/' . $newFilename);
                } catch (FileException $e) {
                    // Gérer les erreurs si besoin
                    $this->addFlash('danger', 'Erreur lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('parametre_utilisateur');
                }
            }

            $data = $form->getData();
            $manager->persist($data);
            $manager->flush();

            $this->addFlash('success', 'Modification éffectué');
            $request->setRequestFormat('html');
            return $this->redirectToRoute('parametre_utilisateur');
        }

        if ($form->isSubmitted() && $request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/form_error.html.twig', [
                'form' => $form,
                'title' => 'Modification Classe'
            ]);
        }

        return $this->render('parametrage/utilisateur/user_edit.html.twig', [
            ...$this->get_params(),
            'form' => $form->createView(),
            'annule_path' => 'parametre_utilisateur',
            'photo_directory' => $photo_directory
        ]);
    }

    #[Route('/utilisateur/delete/{id}', name: 'user_delete', methods: ['POST', 'GET'])]
    public function delete(User $User,  Request $request,  EntityDeleteService $delete, int $id)
    {
        return $delete->deleteEntity($User, $request, 'parametre_utilisateur', $id);
    }
}
