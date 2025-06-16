<?php

namespace App\Controller;

use App\Entity\Toolbox;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppLauncherController
{
    #[Route('/launch-app/{id}', name: 'app_toolbox_launch')]
    public function launchApp(Toolbox $toolbox): Response
    {
        $output = null;
        $returnCode = null;

        // Récupère le lien du script depuis la base de données
        $link = $toolbox->getLink();

        if (!$link) {
            return new Response("Aucun lien de script défini pour cet outil.", 400);
        }

        // Remplace les backslashes pour éviter les problèmes d’interprétation
        $scriptPath = str_replace('\\', '/', $link);

        // Compose la commande CMD pour exécuter le script Python dans un nouveau terminal
        $command = 'cmd.exe /c start "" cmd /k "python ' . $scriptPath . ' & pause"';

        // Exécution de la commande
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return new Response("Erreur lors de l\'ouverture du script Python", 500);
        }

        return new Response("Script Python lancé avec succès !");
    }
}