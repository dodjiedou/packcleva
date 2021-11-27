<?php

namespace App\Entity;

use App\Repository\MaladieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaladieRepository::class)
 */
class Maladie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Contracter::class, mappedBy="maladie")
     */
    private $contracters;

    public function __construct()
    {
        $this->contracters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Contracter[]
     */
    public function getContracters(): Collection
    {
        return $this->contracters;
    }

    public function addContracter(Contracter $contracter): self
    {
        if (!$this->contracters->contains($contracter)) {
            $this->contracters[] = $contracter;
            $contracter->setMaladie($this);
        }

        return $this;
    }

    public function removeContracter(Contracter $contracter): self
    {
        if ($this->contracters->removeElement($contracter)) {
            // set the owning side to null (unless already changed)
            if ($contracter->getMaladie() === $this) {
                $contracter->setMaladie(null);
            }
        }

        return $this;
    }
}
