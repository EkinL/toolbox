<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ToolboxRepository;
use App\Entity\Toolbox;
use Doctrine\ORM\EntityManagerInterface;

final class HomeController extends AbstractController
{
    #[Route('/toolbox', name: 'app_home')]
    public function index(ToolboxRepository $toolboxRepository, EntityManagerInterface $entityManager): Response
    {
        $toolbox = $toolboxRepository->findAll();

        return $this->render('home/index.html.twig', [
            'toolbox' => $toolbox,
        ]);
    }
}
