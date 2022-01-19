<?php

namespace App\Entity;

use App\Repository\RapportAbsenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RapportAbsenceRepository::class)
 */
class RapportAbsence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $debutPeriode;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $finPeriode;

   /**
     * @ORM\Column(type="integer")
     */
    private $nombreAbsence;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreAbsent;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="rapportAbsences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\Column(type="integer")
     */
    private $effectif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutPeriode(): ?string
    {
        return $this->debutPeriode;
    }

    public function setDebutPeriode(string $debutPeriode): self
    {
        $this->debutPeriode = $debutPeriode;

        return $this;
    }

    public function getFinPeriode(): ?string
    {
        return $this->finPeriode;
    }

    public function setFinPeriode(string $finPeriode): self
    {
        $this->finPeriode = $finPeriode;

        return $this;
    }

    public function getNombreAbsence(): ?string
    {
        return $this->nombreAbsence;
    }

    public function setNombreAbsence(string $nombreAbsence): self
    {
        $this->nombreAbsence = $nombreAbsence;

        return $this;
    }

    public function getNombreAbsent(): ?int
    {
        return $this->nombreAbsent;
    }

    public function setNombreAbsent(int $nombreAbsent): self
    {
        $this->nombreAbsent = $nombreAbsent;

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

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): self
    {
        $this->effectif = $effectif;

        return $this;
    }
}
