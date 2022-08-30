<?php

namespace App\Controller\Admin;

use App\Entity\Memoire;
use App\Form\MermoireType;
use App\Repository\MemoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoireController extends AbstractController
{
    #[Route('/admin/memoire', name: 'app_admin_memoire')]
    public function index(MemoireRepository $memoireRepository): Response
    {
        $memoires = $memoireRepository->findAll();
        return $this->render('admin/memoire/admin.html.twig', [
            'controller_name' => 'MemoireController',
            'memoires'=>$memoires
        ]);
    }



    #[Route('/admin/bien/supprimer/{id}', name: 'app_admin_supprimer', requirements: ['id' => '\d+'])]
    public function supprimer(MemoireRepository $memoireRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {
        $memoire = $memoireRepository->find($id);
        $entityManager->remove($memoire);
        $entityManager->flush();

        $this->addFlash(
            'warning',
            "Votre bien à été supprimé !"
        );

        return $this->redirectToRoute('app_admin_memoire');
    }

    #[Route('/admin/memoire/ajouter', name: 'app_admin_memoire_ajouter')]
    #[Route('/admin/modifier/{id}', name: 'app_admin_memoire_modifier', requirements: ['id' => '\d+'])]
    public function ajouter(MemoireRepository $memoireRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {
        $message = "";
        if($request->attributes->get('_route') == "app_admin_memoire_ajouter"){
            $memoire = new Memoire();
            $message = "Votre mémoire à été ajouté !";
        } else{
            $memoire = $memoireRepository->find($id);
            $message = "Votre mémoire à été modifié !";
        }

        $form = $this->createForm(MermoireType::class, $memoire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $memoire = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($memoire);
            $entityManager->flush();
            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_admin_memoire');
        }

        return $this->render('admin/memoire/ajouter.html.twig', [
            'controller_name' => 'MemoireController',
            'form' => $form->createView()
        ]);
    }
}
