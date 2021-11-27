<?php

namespace App\Entity;

use App\Repository\PrendreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrendreRepository::class)
 */
class Prendre
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
    private $datep;

    /**
     * @ORM\ManyToOne(targetEntity=Beneficiaire::class, inversedBy="prendres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beneficiaire;

    /**
     * @ORM\ManyToOne(targetEntity=Vaccin::class, inversedBy="prendres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vaccin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatep(): ?\DateTimeInterface
    {
        return $this->datep;
    }

    public function setDatep(\DateTimeInterface $datep): self
    {
        $this->datep = $datep;

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

    public function getVaccin(): ?Vaccin
    {
        return $this->vaccin;
    }

    public function setVaccin(?Vaccin $vaccin): self
    {
        $this->vaccin = $vaccin;

        return $this;
    }
}
