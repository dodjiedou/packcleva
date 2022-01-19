<?php

namespace App\Entity;

use App\Repository\RapportAbsenceCategorieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RapportAbsenceCategorieRepository::class)
 */
class RapportAbsenceCategorie
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
    private $effectif;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreAbsence;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreAbsent;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="rapportAbsenceCategories")
     */
    private $categorie;

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

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): self
    {
        $this->effectif = $effectif;

        return $this;
    }

    public function getNombreAbsence(): ?int
    {
        return $this->nombreAbsence;
    }

    public function setNombreAbsence(int $nombreAbsence): self
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
