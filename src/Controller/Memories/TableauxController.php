<?php

namespace App\Controller\Memories;

use App\Repository\TableauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableauxController extends AbstractController
{
    #[Route('/memories/tableaux', name: 'app_memories_tableaux')]
    public function index(TableauRepository $tableauRepository): Response
    {
        $tableaux = $tableauRepository->findAll();
        return $this->render('memories/tableaux/tableaux.html.twig', [
            'controller_name' => 'TableauxController',
            'tableaux' => $tableaux
        ]);
    }

    #[Route('/memories/tableaux/{id}', name: 'app_memories_tableaux_memoires', requirements: ['id' => '\w+'])]
    public function tableau(TableauRepository $tableauRepository, $id): Response
    {
        $tableau = $tableauRepository->findByUrl($id);
        return $this->render('memories/tableaux/infosTableau.html.twig', [
            'controller_name' => 'TableauxController',
            'tableau' => $tableau
        ]);
    }

    #[Route('/api/tableaux', name: 'app_get_tableaux')]
    public function getMemoires(Request $request, TableauRepository $tableauRepository)
    {
        return $this->json($tableauRepository->search($request->query->get('q')));
    }
}
