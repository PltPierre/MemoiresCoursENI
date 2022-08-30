<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(UserRepository $userRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        //$user = $userRepository->find($this->getUser());
        $user = $this->getUser();
        $message = "Votre mémoire à été modifié !";

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $memoire = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_profil');
        }
        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
            'form' => $form->createView()
        ]);
    }
}
