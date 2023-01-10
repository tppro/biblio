<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(TranslatorInterface $translator): Response
    {
        //à utiliser pour tous les textes à traduire dans du php
        $message = $translator->trans('Ceci est l\'accueil');

        //si l'utilisateur est connecté
        if ($this->getUser()) {
            $userName = $this->getUser()->getPrenom();
        } else { //sinon
            $userName = '';
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'userName' => $userName,
        ]);
    }
}
