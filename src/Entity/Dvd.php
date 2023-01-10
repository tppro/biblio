<?php

namespace App\Entity;

use App\Repository\DvdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DvdRepository::class)]
class Dvd //extends Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column]
    private ?bool $is_serie = null;

    #[ORM\Column(length: 30)]
    private ?string $producteur = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbmedia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsSerie(): ?bool
    {
        return $this->is_serie;
    }

    public function setIsSerie(bool $is_serie): self
    {
        $this->is_serie = $is_serie;

        return $this;
    }

    public function getProducteur(): ?string
    {
        return $this->producteur;
    }

    public function setProducteur(string $producteur): self
    {
        $this->producteur = $producteur;

        return $this;
    }

    public function getNbmedia(): ?int
    {
        return $this->nbmedia;
    }

    public function setNbmedia(?int $nbmedia): self
    {
        $this->nbmedia = $nbmedia;

        return $this;
    }
}
