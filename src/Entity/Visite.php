<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisiteRepository::class)
 */
class Visite
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
     * @ORM\ManyToOne(targetEntity=CategorieVisite::class, inversedBy="visites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorieVisite;

    /**
     * @ORM\ManyToOne(targetEntity=Beneficiaire::class, inversedBy="visites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beneficiaire;

    /**
     * @ORM\OneToOne(targetEntity=Suivi::class, mappedBy="visite", cascade={"persist", "remove"})
     */
    private $suivi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $photo;

    

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

    public function getCategorieVisite(): ?CategorieVisite
    {
        return $this->categorieVisite;
    }

    public function setCategorieVisite(?CategorieVisite $categorieVisite): self
    {
        $this->categorieVisite = $categorieVisite;

        return $this;
    }

    public function getBeneficiaire(): ?Beneficiaire
    {
        return $this->beneficiaire;
    }

    public function setBeneficiaire(?Beneficiaire $beneficiaire): self
    {
        $this->beneficiaire = $beneficiaire;

        return $this;
    }

    public function getSuivi(): ?Suivi
    {
        return $this->suivi;
    }

    public function setSuivi(Suivi $suivi): self
    {
        // set the owning side of the relation if necessary
        if ($suivi->getVisite() !== $this) {
            $suivi->setVisite($this);
        }

        $this->suivi = $suivi;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

  
}
