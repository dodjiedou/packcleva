<?php

namespace App\Entity;

use App\Repository\SensibilisationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SensibilisationRepository::class)
 */
class Sensibilisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $theme;

    /**
     * @ORM\Column(type="date")
     */
    private $datePrevue;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $animateur;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $facilitateur;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $participantCible;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAnnonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDatePrevue(): ?\DateTimeInterface
    {
        return $this->datePrevue;
    }

    public function setDatePrevue(\DateTimeInterface $datePrevue): self
    {
        $this->datePrevue = $datePrevue;

        return $this;
    }

    public function getAnimateur(): ?string
    {
        return $this->animateur;
    }

    public function setAnimateur(string $animateur): self
    {
        $this->animateur = $animateur;

        return $this;
    }

    public function getFacilitateur(): ?string
    {
        return $this->facilitateur;
    }

    public function setFacilitateur(?string $facilitateur): self
    {
        $this->facilitateur = $facilitateur;

        return $this;
    }

    public function getParticipantCible(): ?string
    {
        return $this->participantCible;
    }

    public function setParticipantCible(string $participantCible): self
    {
        $this->participantCible = $participantCible;

        return $this;
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
}
