<?php

namespace App\Controller;

use App\Entity\History;
use App\Form\HistoryForm;
use App\Repository\HistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/history')]
final class HistoryController extends AbstractController
{
    #[Route(name: 'app_history_index', methods: ['GET'])]
    public function index(HistoryRepository $historyRepository): Response
    {
        return $this->render('history/index.html.twig', [
            'histories' => $historyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_history_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $history = new History();
        $form = $this->createForm(HistoryForm::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($history);
            $entityManager->flush();

            return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('history/new.html.twig', [
            'history' => $history,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_history_show', methods: ['GET'])]
    public function show(History $history): Response
    {
        return $this->render('history/show.html.twig', [
            'history' => $history,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_history_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, History $history, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HistoryForm::class, $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('history/edit.html.twig', [
            'history' => $history,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_history_delete', methods: ['POST'])]
    public function delete(Request $request, History $history, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$history->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($history);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_history_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/launch/{id}', name: 'app_history_launch', methods: ['GET'])]
    public function launch($id, EntityManagerInterface $entityManager): Response
    {
        $toolbox = $entityManager->getRepository(\App\Entity\Toolbox::class)->find($id);

        if (!$toolbox) {
            throw $this->createNotFoundException('Toolbox non trouvée');
        }

        $history = new \App\Entity\History();
        $history->setCreatedAt(new \DateTimeImmutable());
        $history->setTitle('Toolbox "' . $toolbox->getTitle() . '" launched');

        if ($this->getUser()) {
            $history->setUserId($this->getUser());
        }

        $entityManager->persist($history);
        $entityManager->flush();

        return $this->redirectToRoute('app_history_index');
    }
}
