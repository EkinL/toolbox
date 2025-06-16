<?php

namespace App\Controller;

use App\Repository\ToolboxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class HomeController extends AbstractController
{
    #[Route('/toolbox', name: 'app_home')]
    public function index(ToolboxRepository $toolboxRepository, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        $toolboxes = $toolboxRepository->findAll();

        // Récupération de l'email de l'utilisateur connecté
        $email = $user->getUserIdentifier(); // ou $user->getEmail() si ta classe User a cette méthode

        // Filtrage selon l'email
        if ($email === 'user0@example.com') {
            $toolboxes = array_slice($toolboxes, 0, 5); // Affiche les 5 premières
        } elseif ($email === 'user1@example.com') {
            $toolboxes = array_slice($toolboxes, -5); // Affiche les 5 dernières
        }

        return $this->render('home/index.html.twig', [
            'toolboxes' => $toolboxes,
        ]);
    }
}