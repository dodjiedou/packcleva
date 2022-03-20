<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    
    
    /**
     * @ORM\ManyToMany(targetEntity=Cours::class, mappedBy="classes")
     */
    private $cours;

    /**
     * @ORM\OneToMany(targetEntity=Beneficiaire::class, mappedBy="classecde")
     */
    private $beneficiaires;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $annee;

    /**
     * @ORM\OneToMany(targetEntity=RapportAbsence::class, mappedBy="classe")
     */
    private $rapportAbsences;

    /**
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="classe", orphanRemoval=true)
     */
    private $seances;

    

    

    public function __construct()
    {
        
        $this->cours = new ArrayCollection();
        $this->beneficiaires = new ArrayCollection();
        $this->rapportAbsences = new ArrayCollection();
        $this->seances = new ArrayCollection();
        
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
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->addClass($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            $cour->removeClass($this);
        }

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
            $beneficiaire->setClassecde($this);
        }

        return $this;
    }

    public function removeBeneficiaire(Beneficiaire $beneficiaire): self
    {
        if ($this->beneficiaires->removeElement($beneficiaire)) {
            // set the owning side to null (unless already changed)
            if ($beneficiaire->getClassecde() === $this) {
                $beneficiaire->setClassecde(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Categorie
    {
        return $this->category;
    }

    public function setCategory(?Categorie $category): self
    {
        $this->category = $category;

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

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection|RapportAbsence[]
     */
    public function getRapportAbsences(): Collection
    {
        return $this->rapportAbsences;
    }

    public function addRapportAbsence(RapportAbsence $rapportAbsence): self
    {
        if (!$this->rapportAbsences->contains($rapportAbsence)) {
            $this->rapportAbsences[] = $rapportAbsence;
            $rapportAbsence->setClasse($this);
        }

        return $this;
    }

    public function removeRapportAbsence(RapportAbsence $rapportAbsence): self
    {
        if ($this->rapportAbsences->removeElement($rapportAbsence)) {
            // set the owning side to null (unless already changed)
            if ($rapportAbsence->getClasse() === $this) {
                $rapportAbsence->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Seance[]
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seances->contains($seance)) {
            $this->seances[] = $seance;
            $seance->setClasse($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getClasse() === $this) {
                $seance->setClasse(null);
            }
        }

        return $this;
    }

    
}
