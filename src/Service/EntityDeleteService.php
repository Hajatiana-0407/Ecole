<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\Turbo\TurboBundle;

class EntityDeleteService extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager) {}

    /**
     * Delete service auto
     *
     * @param object $entity
     * @param Request $request
     * @param string $path_error
     * @return void
     */
    public function deleteEntity(object $entity, Request $request , string $path_error ='' , int $id )
    {
        if (!$entity && !$request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $this->addFlash('danger', 'Erreur lors de la suppréssion');
            return $this->redirectToRoute($path_error);
        }
 

        if ($request->getPreferredFormat() == TurboBundle::STREAM_FORMAT) {
            $this->manager->remove($entity);
            $this->manager->flush();
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('partials/delete_stream.html.twig', [
                'id' => $id 
            ]);
        }
    }
}
