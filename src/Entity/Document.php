<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name:"documentType", type:"string")]
#[ORM\DiscriminatorMap(["Document" => Document::class, "Book" => Book::class])]
#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $titre = null;

    #[ORM\Column]
    protected ?int $annee = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $resumee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getResumee(): ?string
    {
        return $this->resumee;
    }

    public function setResumee(?string $resumee): self
    {
        $this->resumee = $resumee;

        return $this;
    }
}
