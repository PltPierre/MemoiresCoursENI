<?php

namespace App\Controller\Memories;

use App\Repository\MemoireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoireController extends AbstractController
{
    #[Route('/souvenirs', name: 'app_souvenir')]
    public function index(MemoireRepository $memoireRepository): Response
    {

        $memoires = $memoireRepository->findAll();
        return $this->render('lesSouvenirs.html.twig', [
            'controller_name' => 'MemoireController',
            'memoires'=>$memoires
        ]);
    }

    #[Route('/messouvenirs', name: 'app_souvenirs')]
    public function souvenirs(): Response
    {
        return $this->render("souvenirs.html.twig");
    }

    #[Route('/api/memoires', name: 'app_get_memoires')]
    public function getMemoires(Request $request, MemoireRepository $memoireRepository)
    {
        return $this->json($memoireRepository->search($request->query->get('q')));
    }
}
