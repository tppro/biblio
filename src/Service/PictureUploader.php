<?php

namespace App\Service;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PictureUploader
{
    private Form $form;
    private Document $document;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function init($form, $document)
    {
        $this->form = $form;
        $this->document = $document;
    }

    public function do($type = 'create')
    {
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $newFileName = $this->upload('image');

            if ($newFileName) {
                $this->document->setImage($newFileName);
            }

            if ('create' === $type) {
                $this->entityManager->persist($this->document);
            }
            $this->entityManager->flush();

            return true;
        }
    }

    public function upload($fieldName)
    {
        $pictureFile = $this->form->get($fieldName)->getData();

        //dd('Je passe ici 1');

        if (null === $pictureFile->guessExtension()) {
            throw new FileException('Fichier invalide');
        }

        //dd('Je passe ici 2');

        $newFileName = hash('sha256', uniqid() . microtime() . rand()) . '.' . $pictureFile->guessExtension();

        //dd('Je passe ici 3');

        try {
            //dd('Je passe ici 4');
            $pictureFile->move('uploads', $newFileName);
            return $newFileName;
        } catch (FileException $e) {
            dump($e);
        }

        return null;
    }
}
