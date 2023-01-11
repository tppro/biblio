<?php

namespace App\Service;

use App\Entity\Dvd;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;

class JsonQuery
{
    private GenreRepository $genreRepository;
    private EntityManagerInterface $entityManager;
    private String $baseurl;
    private String $urlquery;
    private String $api_key;

    public function __construct(GenreRepository $genreRepository, EntityManagerInterface $entityManager)
    {
        $this->genreRepository = $genreRepository;
        $this->entityManager = $entityManager;
    }

    public function getDvd($baseurl, $urlquery, $api_key)
    {
        $this->baseurl = $baseurl;
        $this->urlquery = $urlquery;
        $this->api_key = $api_key;
        $url = $this->baseurl.$this->urlquery.$this->api_key;
        $json = $this->getJsonUrl($url);
        $this->insertDvd($json);
        dd($json->results);
    }

    private function insertDvd($json)
    {
        foreach($json->results as $movie) {
            $dvd = new Dvd();
            $dvd->setTitre($movie->original_title);
            $dvd->setAnnee(substr($movie->release_date, 0, 4));
            $dvd->setResumee($movie->overview);

            $this->urlquery = '/movie/'.$movie->id;
            $url = $this->baseurl.$this->urlquery.$this->api_key;
            $json_detail = $this->getJsonUrl($url);
            
            //on cherche dans la base si un genre avec le même libellé existe :
            $query = $this->entityManager->createQueryBuilder('')
                    ->select('g')
                    ->from('App\Entity\Genre', 'g')
                    ->where('g.libelle = :libelle')
                    ->setParameter('libelle', $json_detail->genres[0]->name)
                    ->getQuery()
                    ;
            $result = $query->getResult();

            //dd($result);
        
            //si on trouve un résultat alors :
            if (count($result) > 0) {
                //on récupère le id du libellé
                //et on l'attribut sur le genre du dvd
                $genre = $this->genreRepository->find($result[0]->getId());
                //dd($genre);
                $dvd->setGenre($genre);
            } else { //sinon alors :
                $libelle_genre = $json_detail->genres[0]->name;
                //on créé une instance de l'entité genre
                $genre = new Genre();
                //on lui attribut le libellé recupéré dans le Json
                $genre->setLibelle($libelle_genre);
                //on sauvegarde en base
                $this->entityManager->persist($genre);
                $this->entityManager->flush();
                //et on récupère le nouvel id du genre créé pour
                //l'attribué à atrribut genre du DVD
                //$genre = $this->genreRepository->find($genre->getId());
                $dvd->setGenre($genre);
            }
            
            $dvd->setProducteur($json_detail->production_companies[0]->name);

            $this->entityManager->persist($dvd);
            $this->entityManager->flush();

            //dd($json_detail);
        }
    }

    private function getJsonUrl($url)
    {
        if ($ins = fopen($url, "r")) {
            $content = fgets($ins);
            //dd($content);
            fclose($ins);

            $json = json_decode($content);

            return $json;
        } else {
            return false;
        }

    }
}
