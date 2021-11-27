<?php

namespace App\Entity;

use App\Repository\ContracterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContracterRepository::class)
 */
class Contracter
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
     * @ORM\Column(type="text")
     */
    private $infoAnalyse;

    /**
     * @ORM\Column(type="text")
     */
    private $manifestationMaladie;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $produitPrescrit;

    /**
     * @ORM\Column(type="date")
     */
    private $debutHospitalisation;

    /**
     * @ORM\Column(type="date")
     */
    private $finHospitalisation;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montantSoin;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $etatBeneficiaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreVisite;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombrePrayerSupport;

    

    /**
     * @ORM\ManyToOne(targetEntity=Maladie::class, inversedBy="contracters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $maladie;

    /**
     * @ORM\ManyToOne(targetEntity=Beneficiaire::class, inversedBy="contracters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beneficiaire;
    

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

    public function getInfoAnalyse(): ?string
    {
        return $this->infoAnalyse;
    }

    public function setInfoAnalyse(string $infoAnalyse): self
    {
        $this->infoAnalyse = $infoAnalyse;

        return $this;
    }

    public function getManifestationMaladie(): ?string
    {
        return $this->manifestationMaladie;
    }

    public function setManifestationMaladie(string $manifestationMaladie): self
    {
        $this->manifestationMaladie = $manifestationMaladie;

        return $this;
    }

    public function getProduitPrescrit(): ?string
    {
        return $this->produitPrescrit;
    }

    public function setProduitPrescrit(string $produitPrescrit): self
    {
        $this->produitPrescrit = $produitPrescrit;

        return $this;
    }

    public function getDebutHospitalisation(): ?\DateTimeInterface
    {
        return $this->debutHospitalisation;
    }

    public function setDebutHospitalisation(\DateTimeInterface $debutHospitalisation): self
    {
        $this->debutHospitalisation = $debutHospitalisation;

        return $this;
    }

    public function getFinHospitalisation(): ?\DateTimeInterface
    {
        return $this->finHospitalisation;
    }

    public function setFinHospitalisation(\DateTimeInterface $finHospitalisation): self
    {
        $this->finHospitalisation = $finHospitalisation;

        return $this;
    }

    public function getMontantSoin(): ?string
    {
        return $this->montantSoin;
    }

    public function setMontantSoin(string $montantSoin): self
    {
        $this->montantSoin = $montantSoin;

        return $this;
    }

    public function getEtatBeneficiaire(): ?string
    {
        return $this->etatBeneficiaire;
    }

    public function setEtatBeneficiaire(string $etatBeneficiaire): self
    {
        $this->etatBeneficiaire = $etatBeneficiaire;

        return $this;
    }

    public function getNombreVisite(): ?int
    {
        return $this->nombreVisite;
    }

    public function setNombreVisite(int $nombreVisite): self
    {
        $this->nombreVisite = $nombreVisite;

        return $this;
    }

    public function getNombrePrayerSupport(): ?int
    {
        return $this->nombrePrayerSupport;
    }

    public function setNombrePrayerSupport(int $nombrePrayerSupport): self
    {
        $this->nombrePrayerSupport = $nombrePrayerSupport;

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
            $beneficiaire->addContracter($this);
        }

        return $this;
    }

    public function removeBeneficiaire(Beneficiaire $beneficiaire): self
    {
        if ($this->beneficiaires->removeElement($beneficiaire)) {
            $beneficiaire->removeContracter($this);
        }

        return $this;
    }

    public function getMaladie(): ?Maladie
    {
        return $this->maladie;
    }

    public function setMaladie(?Maladie $maladie): self
    {
        $this->maladie = $maladie;

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
}
