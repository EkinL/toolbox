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

        // Remplace les backslashes pour éviter les erreurs dans le .bat
        $normalizedPath = str_replace('\\', '/', $link);

        // Crée un fichier .bat temporaire dans le dossier temporaire de Windows
        $batContent = '@echo off' . PHP_EOL;
        $batContent .= 'start "" cmd /k python "' . $normalizedPath . '" & pause' . PHP_EOL;

        $batPath = sys_get_temp_dir() . '\launch_toolbox_script.bat';
        file_put_contents($batPath, $batContent);

        // Lancer le .bat avec start (ouvre une nouvelle fenêtre)
        shell_exec('start "" "' . $batPath . '"');

        return new Response("✅ Script Python lancé via .bat !");
    }
}