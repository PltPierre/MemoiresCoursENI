<?php

namespace App\Controller\Admin;

use App\Entity\Tableau;
use App\Form\TableauType;
use App\Repository\TableauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableauController extends AbstractController
{
    #[Route('/admin/tableau', name: 'app_admin_tableau')]
    public function index(TableauRepository $tableauRepository): Response
    {
        $tableaux = $tableauRepository->findAll();
        return $this->render('admin/tableau/tableau.html.twig', [
            'controller_name' => 'TableauController',
            'tableaux'=>$tableaux
        ]);
    }

    #[Route('/admin/tableau/supprimer/{id}', name: 'app_admin_tableau_supprimer', requirements: ['id' => '\d+'])]
    public function supprimer(TableauRepository $tableauRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {
        $memoire = $tableauRepository->find($id);
        $entityManager->remove($memoire);
        $entityManager->flush();

        $this->addFlash(
            'warning',
            "Votre tableau à été supprimé !"
        );

        return $this->redirectToRoute('app_admin_tableau');
    }

    #[Route('/admin/tableau/ajouter', name: 'app_admin_tableau_ajouter')]
    #[Route('/admin/tableau/modifier/{id}', name: 'app_admin_tableau_modifier', requirements: ['id' => '\d+'])]
    public function ajouter(TableauRepository $tableauRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {
        $message = "";
        if($request->attributes->get('_route') == "app_admin_tableau_ajouter"){
            $tableau = new Tableau();
            $message = "Votre tableau à été ajouté !";
        } else{
            $tableau = $tableauRepository->find($id);
            $message = "Votre tableau à été modifié !";
        }

        $form = $this->createForm(TableauType::class, $tableau);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tableau = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($tableau);
            $entityManager->flush();
            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_admin_tableau');
        }

        return $this->render('admin/tableau/ajouterTableau.html.twig', [
            'controller_name' => 'MemoireController',
            'form' => $form->createView()
        ]);
    }
}
