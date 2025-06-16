<?php

namespace App\Controller;

use App\Entity\Toolbox;
use App\Entity\History;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppLauncherController extends AbstractController
{
    #[Route('/toolbox/launch/{id}', name: 'app_toolbox_launch')]
    public function launchApp(Toolbox $toolbox, EntityManagerInterface $em): Response
    {
        $link = $toolbox->getLink();

        if (!$link) {
            return new Response("Aucun lien de lancement défini pour cet outil.", 400);
        }

        // Facultatif : enregistrer l'historique
        // $history = new History();
        // $history->setToolbox($toolbox);
        // $history->setCreatedAt(new \DateTimeImmutable());
        // $em->persist($history);
        // $em->flush();

        // Remplace les backslashes par des slashs, et échappe le chemin
        $normalizedPath = str_replace('\\', '/', $link);
        $scriptPath = escapeshellarg($normalizedPath);

        // Commande correcte pour exécuter le script dans un nouveau terminal Windows
        $command = 'start "" cmd /k python ' . $scriptPath . ' & pause';

        // Utiliser shell_exec ou popen (pas exec) pour bien lancer avec interface
        pclose(popen($command, 'r'));

        return new Response("Script lancé avec succès !");
    }
}