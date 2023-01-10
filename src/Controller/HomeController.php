<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
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
