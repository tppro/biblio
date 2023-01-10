<?php

namespace App\Controller;

use App\Entity\Edition;
use App\Form\EditionType;
use App\Repository\EditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/edition')]
class EditionController extends AbstractController
{
    #[Route('/', name: 'app_edition_index', methods: ['GET'])]
    public function index(EditionRepository $editionRepository): Response
    {
        return $this->render('edition/index.html.twig', [
            'editions' => $editionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_edition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EditionRepository $editionRepository): Response
    {
        $edition = new Edition();
        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editionRepository->save($edition, true);

            return $this->redirectToRoute('app_edition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('edition/new.html.twig', [
            'edition' => $edition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edition_show', methods: ['GET'])]
    public function show(Edition $edition): Response
    {
        return $this->render('edition/show.html.twig', [
            'edition' => $edition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_edition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Edition $edition, EditionRepository $editionRepository): Response
    {
        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editionRepository->save($edition, true);

            return $this->redirectToRoute('app_edition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('edition/edit.html.twig', [
            'edition' => $edition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edition_delete', methods: ['POST'])]
    public function delete(Request $request, Edition $edition, EditionRepository $editionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$edition->getId(), $request->request->get('_token'))) {
            $editionRepository->remove($edition, true);
        }

        return $this->redirectToRoute('app_edition_index', [], Response::HTTP_SEE_OTHER);
    }
}
