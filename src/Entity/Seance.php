<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 */
class Seance
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
    private $dateSeance;

    /**
     * @ORM\Column(type="time")
     */
    private $heureDebutSeance;

    /**
     * @ORM\Column(type="time")
     */
    private $heureFinSeance;
  

    

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="seance", orphanRemoval=true)
     */
    private $absences;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activite;

    

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->absences = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSeance(): ?\DateTimeInterface
    {
        return $this->dateSeance;
    }

    public function setDateSeance(\DateTimeInterface $dateSeance): self
    {
        $this->dateSeance = $dateSeance;

        return $this;
    }

    public function getHeureDebutSeance(): ?\DateTimeInterface
    {
        return $this->heureDebutSeance;
    }

    public function setHeureDebutSeance(\DateTimeInterface $heureDebutSeance): self
    {
        $this->heureDebutSeance = $heureDebutSeance;

        return $this;
    }

    public function getHeureFinSeance(): ?\DateTimeInterface
    {
        return $this->heureFinSeance;
    }

    public function setHeureFinSeance(\DateTimeInterface $heureFinSeance): self
    {
        $this->heureFinSeance = $heureFinSeance;

        return $this;
    }

   

   

    
    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection|Absence[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
            $absence->setSeance($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getSeance() === $this) {
                $absence->setSeance(null);
            }
        }

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    
}
