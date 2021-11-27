<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $intitule;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $domaine;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $numero;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }
}
