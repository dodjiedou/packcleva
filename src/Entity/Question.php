<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateQuestion;

    /**
     * @ORM\ManyToOne(targetEntity=Lettre::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lettre;

    /**
     * @ORM\OneToOne(targetEntity=Reponse::class, mappedBy="question", cascade={"persist", "remove"})
     */
    private $reponse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDateQuestion(): ?\DateTimeInterface
    {
        return $this->dateQuestion;
    }

    public function setDateQuestion(\DateTimeInterface $dateQuestion): self
    {
        $this->dateQuestion = $dateQuestion;

        return $this;
    }

    public function getLettre(): ?Lettre
    {
        return $this->lettre;
    }

    public function setLettre(?Lettre $lettre): self
    {
        $this->lettre = $lettre;

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(Reponse $reponse): self
    {
        // set the owning side of the relation if necessary
        if ($reponse->getQuestion() !== $this) {
            $reponse->setQuestion($this);
        }

        $this->reponse = $reponse;

        return $this;
    }
}
