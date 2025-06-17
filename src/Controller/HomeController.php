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

        $email = $user->getUserIdentifier();

        if ($email === 'user0@example.com') {
            $toolboxes = array_slice($toolboxes, 0, 5);
        } elseif ($email === 'user1@example.com') {
            $toolboxes = array_slice($toolboxes, 6, 1);
        } elseif ($email === 'user2@example.com') {
            $toolboxes = array_slice($toolboxes, 7, 1);
        } elseif ($email === 'user3@example.com') {
            $toolboxes = array_slice($toolboxes, 8, 2);
        } elseif ($email === 'user4@example.com') {
            $toolboxes = array_slice($toolboxes, 11, 1);
        }

        return $this->render('home/index.html.twig', [
            'toolboxes' => $toolboxes,
        ]);
        
    }
}