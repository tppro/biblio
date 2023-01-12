<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\Event;

class GatewaySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        //- le nom de la méthode à appeler (la priorité comme valeur par défaut 0) 
        //[‘eventName’ => ‘methodName’]
        //- Un tableau avec le nom de la méthode à appeler et la priorité. 
        //[‘eventName’ => [‘methodName’, $priority]]
        //- Un tableau de tableau composé des deux précédentes formes. 
        //[‘eventName’ => [[‘methodName’, $priority], [‘methodName2’]]]
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10]
        ];
    }

    public function onKernelRequest(Event $event)
    {
        //execution de la tâche à accomplir
    }
}

/*
HttpKernel $kernel => 'L'objet représentant l'application'
Request $request => 'La requête'
?int $requestType => 'Le type de requête (optionnel, cf. infra "Requêtes maîtresses")'

if (!$event->isMasterRequest()) {
    //traitement à effectué si n'est pas une requête maîtresse
} else { //else

}

//kernel.request
Response $response 'C'est la réponse HTTP'

//kernel.controller
Evenement qui sert à préparer et exécuter le controlleur associer à la requête.
En particulier c'est à de moment là que les arguments de la requête sont construits pour être ensuite passés au contrôleur
callable $controller 'la fonction à executer comme controller'

//kernel.view
#[Template(...)
any $controllerResult 'la valeur retourné par le controller'

//kernel.response
C'est un évènement qui se déclenche juste avant l'envoie de la réponse
- Il peut être utile si on souhaite modifier le réponse elle même
- On va l'utiliser en général pour ajouter/modifier des méta-données comme par exemple les entêtes HTTP ou les cookies
Response $response 'Réponse HTTP'

//kernel.terminate
C'est un évènement que va clore le cycle et on peut s'en servir pour le post traitement
Par exemple, on peut vouloir détruire une session car l'utilisateur s'est déconnecté
Response $response 'Réponse HTTP'

requêtes :
maîtresse : HttpKernelInterface::MASTER_REQUEST
secondaire : HttpKernelInterface::SUB_REQUEST

*/
