<?php

namespace App\Controller;

use App\Entity\Bookj;
use App\Form\BookjType;
use App\Repository\BookjRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bookj')]
class BookjController extends AbstractController
{
    #[Route('/', name: 'app_bookj_index', methods: ['GET'])]
    public function index(BookjRepository $bookjRepository): Response
    {
        return $this->render('bookj/index.html.twig', [
            'bookjs' => $bookjRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bookj_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookjRepository $bookjRepository): Response
    {
        $bookj = new Bookj();
        $form = $this->createForm(BookjType::class, $bookj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookjRepository->save($bookj, true);

            return $this->redirectToRoute('app_bookj_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookj/new.html.twig', [
            'bookj' => $bookj,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookj_show', methods: ['GET'])]
    public function show(Bookj $bookj): Response
    {
        return $this->render('bookj/show.html.twig', [
            'bookj' => $bookj,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bookj_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookj $bookj, BookjRepository $bookjRepository): Response
    {
        $form = $this->createForm(BookjType::class, $bookj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookjRepository->save($bookj, true);

            return $this->redirectToRoute('app_bookj_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookj/edit.html.twig', [
            'bookj' => $bookj,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookj_delete', methods: ['POST'])]
    public function delete(Request $request, Bookj $bookj, BookjRepository $bookjRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookj->getId(), $request->request->get('_token'))) {
            $bookjRepository->remove($bookj, true);
        }

        return $this->redirectToRoute('app_bookj_index', [], Response::HTTP_SEE_OTHER);
    }
}
