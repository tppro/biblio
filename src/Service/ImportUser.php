<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ImportUser {
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    private Array $list;
    private String $content;
    private String $linedelimiter;
    private String $separator;

    public function __construct(String $linedelimiter, String $separator, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->linedelimiter = $linedelimiter;
        $this->separator = $separator;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function loadfile(String $filename)
    {
        $this->list = $this->parseCsv($filename);

        foreach($this->list as $person) {
            $user = new User();
            $user->setPrenom($person[0]);
            $user->setNom($person[1]);
            $user->setRue($person[2]);
            $user->setVille($person[3]);
            //$user->setPays($person[4]);
            $user->setCodepostal(substr($person[5], 0, 5));
            $user->setTelFix($person[6]);
            $user->setTelMobile($person[7]);
            $user->setEmail($person[8]);

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'test'
            );
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->list;
    }

    public function parseCsv(String $filename)
    {
        //on instancie un tableau vide
        $datas = [];
        //On ouvre le fichier en lecture binaire
        if ($file = fopen($filename, "rb")) {
            //on lie le contenu du fichier pour le récupérer
            $this->content = trim(fread($file, filesize($filename)));
            //on récupère les lignes dans le fichier à partir de son contenu
            $lines = explode($this->linedelimiter, $this->content);

            //on parcours les lignes récupérées
            foreach($lines as $line) {
                //si la ligne courante n'est pas vide alors :
                if (trim($line) != '') {
                    //on parse la ligne pour en récupérer les valeurs des différentes colonnes
                    $vals = explode($this->separator, $line);

                    $datas[] = $vals;
                }
            }
            fclose($file);
        }
        array_shift($datas); //on enlève la première cellule en début de tableau

        return $datas;
    }
}
