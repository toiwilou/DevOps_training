<?php

namespace App\Service;

use App\Entity\Liste;
use App\Repository\ListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeService
{
    private $entityManager;
    private $listeRepository;

    public function __construct(
        ListeRepository $listeRepository,
        EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->listeRepository = $listeRepository;
    }

    public function getListes(): array
    {
        return $this->listeRepository->findAll();
    }

    public function create(Request $request): void
    {
        $liste = new Liste();
        $liste->setName($request->request->get('name'));

        $this->entityManager->persist($liste);
        $this->entityManager->flush();
    }
}