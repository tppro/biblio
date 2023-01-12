<?php

namespace App\Event;

use App\Entity\Book;
use Symfony\Contracts\EventDispatcher\Event;

class UpdateBookEvent extends Event
{
    const UPDATE_BOOK_EVENT = 'book.update';

    public function __construct(private Book $book)
    {
        
    }

    public function getBook() : Book
    {
        return $this->book;
    }
}
