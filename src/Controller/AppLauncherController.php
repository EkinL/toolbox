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

        // 🔧 Normalisation du chemin
        $normalizedPath = str_replace('\\', '/', $link); // Windows accepte les slashs
        $scriptPath = escapeshellarg($normalizedPath); // sécurise le chemin

        // 🧪 Pour debug visuel : retour complet
        $command = 'cmd /c start "" cmd /k python ' . $scriptPath . ' & pause';

        try {
            // Lancement dans une fenêtre visible
            pclose(popen($command, 'r'));

            return new Response("✅ Script lancé dans une nouvelle fenêtre !");
        } catch (\Exception $e) {
            return new Response("❌ Erreur lors du lancement : " . $e->getMessage(), 500);
        }
    }
}