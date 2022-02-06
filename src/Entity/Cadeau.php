<?php

namespace App\Entity;

use App\Repository\CadeauRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\Inheritance;
use Doctrine\ORM\Mapping\Discriminator;

/**
 * @ORM\Entity(repositoryClass=CadeauRepository::class);
 * 
 */

 class Cadeau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    //abstract

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomArticle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mesureArticle;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreFille;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreGarcon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticle(): ?string
    {
        return $this->nomArticle;
    }

    public function setNomArticle(string $nomArticle): self
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    public function getMesureArticle(): ?string
    {
        return $this->mesureArticle;
    }

    public function setMesureArticle(string $mesureArticle): self
    {
        $this->mesureArticle = $mesureArticle;

        return $this;
    }

    public function getNombreFille(): ?int
    {
        return $this->nombreFille;
    }

    public function setNombreFille(int $nombreFille): self
    {
        $this->nombreFille = $nombreFille;

        return $this;
    }

    public function getNombreGarcon(): ?int
    {
        return $this->nombreGarcon;
    }

    public function setNombreGarcon(int $nombreGarcon): self
    {
        $this->nombreGarcon = $nombreGarcon;

        return $this;
    }
}
