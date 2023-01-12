<?php

namespace App\EventListener;

use App\Event\AddBookEvent;
use Psr\Log\LoggerInterface;

class BookListener
{
    public function __construct(private LoggerInterface $logger)
    {
        
    }

    public function onAddBookListener(AddBookEvent $event)
    {
        //dd('Hello, je suis en train d\'écouter  l\'évènement book.add !');
        $this->logger->debug('Hello, je suis en train d\'écouter  l\'évènement book.add ! Le livre ajouté est : '.$event->getBook()->getTitre());
    }
}
