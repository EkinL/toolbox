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
        // 1. Vérifie que le lien est bien défini
        $link = $toolbox->getLink();

        if (!$link) {
            return new Response("Aucun lien de lancement défini pour cet outil.", 400);
        }

        // 2. Crée une ligne dans l'historique
        // $history = new History();
        // $history->setToolbox($toolbox);
        // $history->setCreatedAt(new \DateTimeImmutable());

        // $em->persist($history);
        // $em->flush();

        // 3. Lance le script dans le terminal via AppleScript (macOS uniquement)
        $escapedCommand = escapeshellcmd($link);
        $script = sprintf('osascript -e \'tell application "Terminal" to do script "%s"\'', $escapedCommand);

        $output = null;
        $returnCode = null;
        exec($script, $output, $returnCode);

        if ($returnCode !== 0) {
            return new Response("Erreur lors du lancement de l'application.", 500);
        }

        return new Response("Application lancée et historique enregistré !");
    }
}