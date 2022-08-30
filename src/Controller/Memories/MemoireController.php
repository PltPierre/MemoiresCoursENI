<?php

namespace App\Controller\Memories;

use App\Repository\MemoireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoireController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(MemoireRepository $memoireRepository): Response
    {

        $memoires = $memoireRepository->findAll();
        return $this->render('accueil.html.twig', [
            'controller_name' => 'MemoireController',
            'memoires'=>$memoires
        ]);
    }

    #[Route('/messouvenirs', name: 'app_souvenirs')]
    public function souvenirs(): Response
    {
        return $this->render("souvenirs.html.twig");
    }
}
