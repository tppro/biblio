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

//Evènement bibliothèque tierce :
Doctrine :
// src/Entity/Product.php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Product
{
    // ...
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}

preRemove qui est déclenché juste avant l'execution la méthode EntityManager#remove()
postRemove qui est déclenché juste après l'execution la méthode EntityManager#remove()
prePersist qui est déclenché juste avant l'execution la méthode EntityManager#persist()
postPersist qui est déclenché juste après l'execution la méthode EntityManager#persist()
preUpdate qui est déclenché juste avant l'execution de la méthode EntityManager#flush()
postUpdate qui est déclenché juste après l'execution de la méthode EntityManager#flush()
postLoad lorsque l'entité est chargé dans l'EntityManager.

Evènement concernant la sécurité
l'authentification :
CheckPassportEvent déclenché lors de initialisation de la connexion et la création du token CSRF
--------
AuthentificationTokenCreatedEvent déclenché lorsque le token de connexion a été créé et que l'utilisateur qui souhaite se connecter a été instancié.
--------
AuthentificationSuccessEvent déclenché juste avant que l'utilisateur soit connecté.
Ici l'utilisateur existe bien, le mot de passe a été vérifié.
C'est le dernier évènement déclenché pendant lequel on peut faire echouer encore la connexion 
Dans ce cas, on utiliserait un throw new AuthentificationException("message")
--------
LoginSuccessEvent déclenché quand la connexion de l'utilisateur a aboutie.
--------
LoginFailureEvent déclenché quand la connexion de l'utilisateur a écouché.
--------
LogoutEvent déclenché juste avant la déconnexion de l'utilisateur.
--------
TokenDeauthenticatedEvent déclenché lorsque le mot de passe a changé et que l'utilisateur est automatiquement déconnecté.
--------
Evènement de formulaire :
PRE_SET_DATA déclenché juste avant l'affichage d'un formulaire.
--------
POST_SET_DATA déclenché juste après l'affichage d'un formulaire,
la modification n'est plus possible à ce stade.
--------
PRE_SUBMIT déclenché juste avant la soumission / réception du formulaire et avant sa sérialisation.
A ce stade l'ajout / modification / suppression des champs de formulaire est possible, leurs valeurs également
--------
SUBMIT Déclenché avant la conversion du formulaire en objet, seule la modification des valeurs reste possible
--------
POST_SUBMIT Déclenché après la réception du formulaire. Plus aucune modification possible, seule la lecture est possible.



*/
