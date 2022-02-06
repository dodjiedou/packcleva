<?php

namespace App\Entity;

use App\Repository\LettreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LettreRepository::class)
 */
class Lettre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $correspondant;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $envoiReception;

    /**
     * @ORM\Column(type="date")
     */
    private $dateExpedition;

    /**
     * @ORM\Column(type="date")
     */
    private $dateReception;

    /**
     * @ORM\ManyToOne(targetEntity=Beneficiaire::class, inversedBy="lettres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beneficiaire;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="lettre", orphanRemoval=true)
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorrespondant(): ?string
    {
        return $this->correspondant;
    }

    public function setCorrespondant(string $correspondant): self
    {
        $this->correspondant = $correspondant;

        return $this;
    }

    public function getEnvoiReception(): ?string
    {
        return $this->envoiReception;
    }

    public function setEnvoiReception(string $envoiReception): self
    {
        $this->envoiReception = $envoiReception;

        return $this;
    }

    public function getDateExpedition(): ?\DateTimeInterface
    {
        return $this->dateExpedition;
    }

    public function setDateExpedition(\DateTimeInterface $dateExpedition): self
    {
        $this->dateExpedition = $dateExpedition;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(\DateTimeInterface $dateReception): self
    {
        $this->dateReception = $dateReception;

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

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setLettre($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getLettre() === $this) {
                $question->setLettre(null);
            }
        }

        return $this;
    }
}
