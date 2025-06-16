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

        // Normaliser le chemin : remplacer les backslashes par des slashs
        $normalizedPath = str_replace('\\', '/', $link);
        $scriptPath = escapeshellarg($normalizedPath); // sécurise les espaces et caractères spéciaux

        // Commande Windows pour exécuter le script Python dans une nouvelle fenêtre CMD
        $command = 'cmd.exe /c start "" "cmd /k python ' . $scriptPath . ' & pause"';

        $output = null;
        $returnCode = null;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return new Response("Erreur lors de l'exécution du script", 500);
        }

        return new Response("Script lancé avec succès !");
    }
}