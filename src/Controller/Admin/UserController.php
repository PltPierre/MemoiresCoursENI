<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_admin_user')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/user/user.html.twig', [
            'controller_name' => 'AgentController',
            'users' => $users
        ]);
    }

    #[Route('/admin/user/supprimer/{id}', name: 'app_admin_user_supprimer', requirements: ['id' => '\d+'])]
    public function supprimer(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'warning',
            "l'utilisateur a été supprimé !"
        );

        return $this->redirectToRoute('app_admin_user');
    }

    #[Route('/admin/user/ajouter', name: 'app_admin_user_ajouter')]
    #[Route('/admin/agent/modifier/{id}', name: 'app_admin_user_modifier', requirements: ['id' => '\d+'])]
    public function ajouter(UserRepository $userRepository,UserPasswordHasherInterface $hasher, Request $request, EntityManagerInterface $entityManager, $id=null): Response
    {
        $message = "";
        if($request->attributes->get('_route') == "app_admin_user_ajouter"){
            $user = new User();
            $message = "Votre utilisateur à été ajouté !";
        } else{
            $user = $userRepository->find($id);
            $message = "Votre utilisateur à été modifié !";
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_admin_user');
        }


        return $this->render('admin/user/ajouterUser.html.twig', [
            'controller_name' => 'AgentController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/agent/modifier/{id}', name: 'app_admin_user_modifier', requirements: ['id' => '\d+'])]
    public function edit(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, $id = null): Response
    {
        $user = $userRepository->find($id);
        $message = "Votre agent a été modifié !";

        $form = $this->createForm(UserType::class, $user,[
            'usePassword'=>false
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_admin_user');
        }


        return $this->render('admin/user/editUser.html.twig', [
            'controller_name' => 'AgentController',
            'form' => $form->createView()
        ]);
    }
}
