<?php

namespace App\Event;

use App\Entity\Book;
use Symfony\Contracts\EventDispatcher\Event;

class AddBookEvent extends Event
{
    const ADD_BOOK_EVENT = 'book.add';

    public function __construct(private Book $book)
    {
        
    }

    public function getBook() : Book
    {
        return $this->book;
    }
}
