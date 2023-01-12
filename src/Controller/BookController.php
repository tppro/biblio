<?php

namespace App\Controller;

use App\Entity\Book;
use App\Event\AddBookEvent;
use App\Event\UpdateBookEvent;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Service\PictureUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[Route('/book')]
class BookController extends AbstractController
{

    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
        
    }

    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookRepository $bookRepository, PictureUploader $pictureUploader): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($book->getImage()) {
                $pictureUploader->init($form, $book);
                $pictureUploader->do('create');
            }
            
            //on créé l'évènement ADD_BOOK_EVENT 
            $addBookEvent = new AddBookEvent($book);
            //maintenant on dispatch l'évènement :
            $this->eventDispatcher->dispatch($addBookEvent, AddBookEvent::ADD_BOOK_EVENT);

            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, BookRepository $bookRepository, PictureUploader $pictureUploader): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($book->getImage()) {
                $pictureUploader->init($form, $book);
                $pictureUploader->do('update');
            }

            //on créé l'évènement UPDATE_BOOK_EVENT 
            $updateBookEvent = new UpdateBookEvent($book);
            $this->eventDispatcher->dispatch($updateBookEvent, UpdateBookEvent::UPDATE_BOOK_EVENT);

            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
