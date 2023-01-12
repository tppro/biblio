<?php

namespace App\EventSubscriber;

use App\Event\AddBookEvent;
use App\Service\Sendmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BookSubscriber implements EventSubscriberInterface
{
    public function __construct(private Sendmail $sendmail)
    {

    }

    public static function getSubscribedEvents() : array
    {
        return [
            AddBookEvent::ADD_BOOK_EVENT => ['onAddBookEvent', 100]
        ];
    }

    public function onAddBookEvent(AddBookEvent $event)
    {
        $book = $event->getBook();
        $from = 'event@biblio.fr';
        $to = 'tristan@plumet.com';
        $subject = 'Un nouveau livre est à ranger en rayon';
        $message = 'Le livre '.$book->getTitre().' a été indexé en base de données, merci de le ranger dans le rayon adéquate';
        $template = 'event';
        $variables = ['message' => $message];
        $this->sendmail->send($from, $to, $subject, $template, $variables);

        //traitement à effectuer
        //dd('Test Subscriber '.$event->getBook()->getTitre());

    }
}
