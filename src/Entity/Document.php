<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name:"documentType", type:"string")]
//#[ORM\DiscriminatorMap(["Document" => Document::class, "Book" => Book::class])]
#[ORM\DiscriminatorMap(["Document" => Document::class, "Book" => Book::class, "Dvd" => Dvd::class, "Journal" => Journal::class])]
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

    #[ORM\ManyToOne(inversedBy: 'documents')]
    private ?Exemplaire $exemplaire = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    private ?Genre $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        
    }

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

    public function getExemplaire(): ?Exemplaire
    {
        return $this->exemplaire;
    }

    public function setExemplaire(?Exemplaire $exemplaire): self
    {
        $this->exemplaire = $exemplaire;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
