<?php

namespace App\EventSubscriber;

use App\Event\AddBookEvent;
use App\Event\UpdateBookEvent;
use App\Service\Sendmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

class BookSubscriber implements EventSubscriberInterface
{
    public function __construct(private Sendmail $sendmail)
    {

    }

    public static function getSubscribedEvents() : array
    {
        return [
            AddBookEvent::ADD_BOOK_EVENT => ['onAddBookEvent', 100],
            UpdateBookEvent::UPDATE_BOOK_EVENT => ['onUpdateBookEvent', 100],
        ];
    }

    public function onAddBookEvent(AddBookEvent $event)
    {
        $message = 'Le livre ###INFO### a été indexé en base de données, merci de le ranger dans le rayon adéquate';
        $message = $this->setMessage($event, $message);
        $data = [
            'from' => 'event@biblio.fr',
            'to' => 'tristan@plumet.com',
            'subject' => 'Un nouveau livre est à ranger en rayon',
            'template' => 'event',
            'variables' => ['message' => $message],
        ];
        $this->sendEmail($data);

        //traitement à effectuer
        //dd('Test Subscriber '.$event->getBook()->getTitre());

    }

    private function setMessage(Event $event, String $message) : String
    {
        $book = $event->getBook();
        $message = str_replace('###INFO###', $book->getTitre(), $message);
        return $message;
    }

    private function sendEmail(Array $data)
    {
        $this->sendmail->send($data['from'], $data['to'], $data['subject'], $data['template'], $data['variables']);

    }

    public function onUpdateBookEvent(UpdateBookEvent $event)
    {
        //dd('Le livre '.$event->getBook()->getTitre().' a été modifié !');
        $message = 'Le livre ###INFO### a été modifié en base de données, merci de faire le nécessaire dans l\'inventaire';
        $message = $this->setMessage($event, $message);
        $data = [
            'from' => 'event@biblio.fr',
            'to' => 'tristan@plumet.com',
            'subject' => 'Un livre nécessite votre attention pour l\'inventaire',
            'template' => 'event',
            'variables' => ['message' => $message],
        ];
        $this->sendEmail($data);
    }
}
