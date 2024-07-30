<?php

namespace App\Controller;

use App\Service\HomeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'listes' => $this->homeService->getListes()
        ]);
    }

    #[Route('/create', name: 'app_create')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $this->homeService->create($request);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/create.html.twig');
    }
}
