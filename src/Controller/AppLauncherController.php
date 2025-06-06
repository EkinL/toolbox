<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppLauncherController
{
    #[Route('/launch-app', name: 'launch_app')]
    public function launchApp(): Response
    {
        $output = null;
        $returnCode = null;

        // open le terminal et exécute la commande echo "Hello, World!"
        exec('osascript -e \'tell application "Terminal" to do script "python3 /Users/lilian/Downloads/script/Simple.py"\'', $output, $returnCode);



        if ($returnCode !== 0) {
            return new Response("Erreur lors du lancement de l'application", 500);
        }

        return new Response("Application lancée avec succès !");
    }
}
