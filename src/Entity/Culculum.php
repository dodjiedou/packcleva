<?php

namespace App\Entity;

use App\Repository\CulculumRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CulculumRepository::class)
 */
class Culculum
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $numeroLecon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titreLecon;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="culculums")
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNumeroLecon(): ?string
    {
        return $this->numeroLecon;
    }

    public function setNumeroLecon(string $numeroLecon): self
    {
        $this->numeroLecon = $numeroLecon;

        return $this;
    }

    public function getTitreLecon(): ?string
    {
        return $this->titreLecon;
    }

    public function setTitreLecon(string $titreLecon): self
    {
        $this->titreLecon = $titreLecon;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
