<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
     * @ORM\OneToMany(targetEntity=Beneficiaire::class, mappedBy="categorie")
     */
    private $beneficiaires;

    /**
     * @ORM\OneToMany(targetEntity=Classe::class, mappedBy="categorie")
     */
    private $classes;

    /**
     * @ORM\OneToMany(targetEntity=RapportAbsenceCategorie::class, mappedBy="categorie")
     */
    private $rapportAbsenceCategories;

    /**
     * @ORM\OneToMany(targetEntity=Culculum::class, mappedBy="categorie")
     */
    private $culculums;

    

    public function __construct()
    {
        $this->beneficiaires = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->rapportAbsenceCategories = new ArrayCollection();
        $this->culculums = new ArrayCollection();
        
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
     * @return Collection|Beneficiaire[]
     */
    public function getBeneficiaires(): Collection
    {
        return $this->beneficiaires;
    }

    public function addBeneficiaire(Beneficiaire $beneficiaire): self
    {
        if (!$this->beneficiaires->contains($beneficiaire)) {
            $this->beneficiaires[] = $beneficiaire;
            $beneficiaire->setCategorie($this);
        }

        return $this;
    }

    public function removeBeneficiaire(Beneficiaire $beneficiaire): self
    {
        if ($this->beneficiaires->removeElement($beneficiaire)) {
            // set the owning side to null (unless already changed)
            if ($beneficiaire->getCategorie() === $this) {
                $beneficiaire->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Classe[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setCategorie($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getCategorie() === $this) {
                $class->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RapportAbsenceCategorie[]
     */
    public function getRapportAbsenceCategories(): Collection
    {
        return $this->rapportAbsenceCategories;
    }

    public function addRapportAbsenceCategory(RapportAbsenceCategorie $rapportAbsenceCategory): self
    {
        if (!$this->rapportAbsenceCategories->contains($rapportAbsenceCategory)) {
            $this->rapportAbsenceCategories[] = $rapportAbsenceCategory;
            $rapportAbsenceCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeRapportAbsenceCategory(RapportAbsenceCategorie $rapportAbsenceCategory): self
    {
        if ($this->rapportAbsenceCategories->removeElement($rapportAbsenceCategory)) {
            // set the owning side to null (unless already changed)
            if ($rapportAbsenceCategory->getCategorie() === $this) {
                $rapportAbsenceCategory->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Culculum[]
     */
    public function getCulculums(): Collection
    {
        return $this->culculums;
    }

    public function addCulculum(Culculum $culculum): self
    {
        if (!$this->culculums->contains($culculum)) {
            $this->culculums[] = $culculum;
            $culculum->setCategorie($this);
        }

        return $this;
    }

    public function removeCulculum(Culculum $culculum): self
    {
        if ($this->culculums->removeElement($culculum)) {
            // set the owning side to null (unless already changed)
            if ($culculum->getCategorie() === $this) {
                $culculum->setCategorie(null);
            }
        }

        return $this;
    }

   

}
