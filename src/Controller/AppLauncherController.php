<?php

namespace App\Controller;

use App\Entity\Toolbox;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppLauncherController extends AbstractController
{
    #[Route('/toolbox/launch/{id}', name: 'app_toolbox_launch')]
    public function launchApp(Toolbox $toolbox): Response
    {
        $link = $toolbox->getLink();

        if (!$link) {
            return new Response("❌ Aucun lien de lancement défini pour cet outil.", 400);
        }

        // Normalise le chemin pour Windows (slashs acceptés)
        $normalizedPath = str_replace('\\', '/', $link);
        $scriptPath = escapeshellarg($normalizedPath);

        // Commande pour ouvrir un nouveau terminal, exécuter le script et garder la fenêtre ouverte
        $command = 'start "" cmd /k python ' . $scriptPath . ' & pause';

        // Lancer la commande via shell_exec pour exécution réelle (non bloquante)
        shell_exec($command);

        return new Response("✅ Script Python lancé dans une nouvelle fenêtre !");
    }
}