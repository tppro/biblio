<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name:"documentType", type:"string")]
#[ORM\DiscriminatorMap(["Document" => Document::class, "Book" => Book::class])]
//#[ORM\DiscriminatorMap(["Document" => Document::class, "Book" => Book::class, "Dvd" => Dvd::class, "Journal" => Journal::class])]
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

    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Genre::class)]
    private Collection $genre;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
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

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
            $genre->setDocument($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genre->removeElement($genre)) {
            // set the owning side to null (unless already changed)
            if ($genre->getDocument() === $this) {
                $genre->setDocument(null);
            }
        }

        return $this;
    }
}
