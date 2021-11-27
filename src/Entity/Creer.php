<?php

namespace App\Entity;

use App\Repository\CreerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreerRepository::class)
 */
class Creer
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
    private $dateAnnonce;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRencontre;

    /**
     * @ORM\Column(type="time")
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="time")
     */
    private $heureFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pointcle;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $depense;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $indicateurImpact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAnnonce(): ?\DateTimeInterface
    {
        return $this->dateAnnonce;
    }

    public function setDateAnnonce(\DateTimeInterface $dateAnnonce): self
    {
        $this->dateAnnonce = $dateAnnonce;

        return $this;
    }

    public function getDateRencontre(): ?\DateTimeInterface
    {
        return $this->dateRencontre;
    }

    public function setDateRencontre(\DateTimeInterface $dateRencontre): self
    {
        $this->dateRencontre = $dateRencontre;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getPointcle(): ?string
    {
        return $this->pointcle;
    }

    public function setPointcle(string $pointcle): self
    {
        $this->pointcle = $pointcle;

        return $this;
    }

    public function getDepense(): ?string
    {
        return $this->depense;
    }

    public function setDepense(string $depense): self
    {
        $this->depense = $depense;

        return $this;
    }

    public function getIndicateurImpact(): ?string
    {
        return $this->indicateurImpact;
    }

    public function setIndicateurImpact(string $indicateurImpact): self
    {
        $this->indicateurImpact = $indicateurImpact;

        return $this;
    }
}
