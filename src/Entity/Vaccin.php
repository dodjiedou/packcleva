<?php

namespace App\Entity;

use App\Repository\VaccinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VaccinRepository::class)
 */
class Vaccin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Prendre::class, mappedBy="vaccin")
     */
    private $prendres;

    public function __construct()
    {
        $this->prendres = new ArrayCollection();
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

    /**
     * @return Collection|Prendre[]
     */
    public function getPrendres(): Collection
    {
        return $this->prendres;
    }

    public function addPrendre(Prendre $prendre): self
    {
        if (!$this->prendres->contains($prendre)) {
            $this->prendres[] = $prendre;
            $prendre->setVaccin($this);
        }

        return $this;
    }

    public function removePrendre(Prendre $prendre): self
    {
        if ($this->prendres->removeElement($prendre)) {
            // set the owning side to null (unless already changed)
            if ($prendre->getVaccin() === $this) {
                $prendre->setVaccin(null);
            }
        }

        return $this;
    }
}
