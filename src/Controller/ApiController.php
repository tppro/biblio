<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(CountryRepository $countryRepository, SerializerInterface $serializer): Response
    {
        //return new Response("test");
        $countries = $countryRepository->findAll();
        return $this->json($countries);

        //$json = $serializer->serialize($countries, 'json', ['groups' => ['normal']]);
        //return new Response($json);
        /*
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
        */
    }
}
