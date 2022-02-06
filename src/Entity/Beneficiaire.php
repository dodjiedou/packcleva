<?php

namespace App\Entity;

use App\Repository\BeneficiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeneficiaireRepository::class)
 */
class Beneficiaire 
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
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $classe;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $religion;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $nomTuteur;



    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $rangOccupe;


    
    /**
     * @ORM\OneToMany(targetEntity=Contracter::class, mappedBy="beneficiaire")
     */
    private $contracters;

    /**
     * @ORM\OneToMany(targetEntity=Prendre::class, mappedBy="beneficiaire", orphanRemoval=true)
     */
    private $prendres;

    
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="beneficiaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classecde;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="beneficiaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Lettre::class, mappedBy="beneficiaire", orphanRemoval=true)
     */
    private $lettres;


    public function __construct()
    {
        
        $this->contracters = new ArrayCollection();
        $this->prendres = new ArrayCollection();
        $this->lettres = new ArrayCollection();
       
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }


   

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(string $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }


    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
   

   

    public function getReligion(): ?string
    {
        return $this->religion;
    }

    public function setReligion(string $religion): self
    {
        $this->religion = $religion;

        return $this;
    }

    public function getNomTuteur(): ?string
    {
        return $this->nomTuteur;
    }

    public function setNomTuteur(?string $nomTuteur): self
    {
        $this->nomTuteur = $nomTuteur;

        return $this;
    }

   

    public function getRangOccupe(): ?string
    {
        return $this->rangOccupe;
    }

    public function setRangOccupe(?string $rangOccupe): self
    {
        $this->rangOccupe = $rangOccupe;

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
            $contracter->setBeneficiaire($this);
        }

        return $this;
    }

    public function removeContracter(Contracter $contracter): self
    {
         if ($this->contracters->removeElement($contracter)) {
            // set the owning side to null (unless already changed)
            if ($contracter->getBeneficiaire() === $this) {
                $contracter->setBeneficiaire(null);
            }
        }
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
            $prendre->setBeneficiaire($this);
        }

        return $this;
    }

    public function removePrendre(Prendre $prendre): self
    {
        if ($this->prendres->removeElement($prendre)) {
            // set the owning side to null (unless already changed)
            if ($prendre->getBeneficiaire() === $this) {
                $prendre->setBeneficiaire(null);
            }
        }

        return $this;
    }

    
    public function getAge($date) 
    {
        $age = date('Y') - date('Y', strtotime($date));
        if (date('md') < date('md', strtotime($date))) {
        return $age - 1;
        }
         return $age;
    }

   

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getClassecde(): ?Classe
    {
        return $this->classecde;
    }

    public function setClassecde(?Classe $classecde): self
    {
        $this->classecde = $classecde;

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

    /**
     * @return Collection|Lettre[]
     */
    public function getLettres(): Collection
    {
        return $this->lettres;
    }

    public function addLettre(Lettre $lettre): self
    {
        if (!$this->lettres->contains($lettre)) {
            $this->lettres[] = $lettre;
            $lettre->setBeneficiaire($this);
        }

        return $this;
    }

    public function removeLettre(Lettre $lettre): self
    {
        if ($this->lettres->removeElement($lettre)) {
            // set the owning side to null (unless already changed)
            if ($lettre->getBeneficiaire() === $this) {
                $lettre->setBeneficiaire(null);
            }
        }

        return $this;
    }

    

    
}
