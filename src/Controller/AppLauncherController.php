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

        // Normalise le chemin pour PowerShell (slash ou double backslash)
        $normalizedPath = str_replace('\\', '/', $link);

        // Commande PowerShell : ouvre un nouveau terminal avec le script Python
        $psCommand = 'Start-Process cmd -ArgumentList \'/k python "' . $normalizedPath . '" & pause\'';

        // Construction de la commande complète
        $fullCommand = 'powershell -Command ' . escapeshellarg($psCommand);

        // Exécution
        shell_exec($fullCommand);

        return new Response("✅ Script Python lancé dans un nouveau terminal Windows !");
    }
}