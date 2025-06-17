<?php
namespace App\Controller;

use App\Entity\Toolbox;
use App\Entity\History;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class AppLauncherController extends AbstractController
{
    #[Route('/launch-app/{id}', name: 'app_toolbox_launch')]
    public function launchApp(
        Toolbox $toolbox,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {
        // Récupère le lien du script depuis la base de données
        $link = $toolbox->getLink();

        if (!$link) {
            return new Response("Aucun lien de script défini pour cet outil.", 400);
        }

        // --- Création de l'historique AVANT l'exécution ---
        $history = new History();
        $history->setCreatedAt(new \DateTimeImmutable());
        $history->setTitle('Toolbox "' . $toolbox->getTitle() . '" demandé via AppLauncher');

        $user = $security->getUser();
        if ($user) {
            $history->setUserId($user);
        }

        $entityManager->persist($history);
        $entityManager->flush();

        // --- Exécution du script ---
        $output = null;
        $returnCode = null;
        $scriptPath = str_replace('\\', '/', $link);
        $command = 'cmd.exe /c start "" cmd /k "python ' . $scriptPath . ' & pause"';
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return new Response("Erreur lors de l'ouverture du script Python", 500);
        }

        return new Response("Script Python lancé avec succès !");
    }
}