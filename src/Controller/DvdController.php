<?php

namespace App\Controller;

use App\Entity\Dvd;
use App\Form\DvdType;
use App\Repository\DvdRepository;
use App\Service\JsonQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dvd')]
class DvdController extends AbstractController
{
    #[Route('/', name: 'app_dvd_index', methods: ['GET'])]
    public function index(DvdRepository $dvdRepository, Request $request): Response
    {
        //on récupère dans l'url la valeur du paramètre "page"
        $page = $request->query->getInt('page', 1);

        $result = $dvdRepository->findDvdsPaginated($page, 5);
        //dd($result);

        return $this->render('dvd/index.html.twig', [
            //'dvds' => $dvdRepository->findAll(),
            'dvds' => $result['data'],
            'pages' => $result['pages'],
            'currentPage' => $result['currentPage'],
            'limit' => $result['limit'],
            'path' => 'app_dvd_index',
        ]);
    }

    #[Route('/jsonquery', name: 'app_dvd_jsonquery', methods: ['GET'])]
    public function jsonquery(JsonQuery $jsonQuery)
    {
        $baseurl = 'https://api.themoviedb.org/3';
        $urlquery = '/movie/popular';
        $api_key = '?api_key=2c0e7f4f407b11f7bbc052e2e3b28ad3';
        $jsonQuery->getDvd($baseurl, $urlquery, $api_key);
    }
    
    #[Route('/new', name: 'app_dvd_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DvdRepository $dvdRepository): Response
    {
        $dvd = new Dvd();
        $form = $this->createForm(DvdType::class, $dvd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dvdRepository->save($dvd, true);

            return $this->redirectToRoute('app_dvd_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dvd/new.html.twig', [
            'dvd' => $dvd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dvd_show', methods: ['GET'])]
    public function show(Dvd $dvd): Response
    {
        return $this->render('dvd/show.html.twig', [
            'dvd' => $dvd,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dvd_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dvd $dvd, DvdRepository $dvdRepository): Response
    {
        $form = $this->createForm(DvdType::class, $dvd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dvdRepository->save($dvd, true);

            return $this->redirectToRoute('app_dvd_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dvd/edit.html.twig', [
            'dvd' => $dvd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dvd_delete', methods: ['POST'])]
    public function delete(Request $request, Dvd $dvd, DvdRepository $dvdRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dvd->getId(), $request->request->get('_token'))) {
            $dvdRepository->remove($dvd, true);
        }

        return $this->redirectToRoute('app_dvd_index', [], Response::HTTP_SEE_OTHER);
    }
}
