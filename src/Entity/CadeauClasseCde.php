<?php

namespace App\Entity;

use App\Repository\CadeauClasseCdeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CadeauClasseCdeRepository::class)
 */
class CadeauClasseCde extends Cadeau
{
     

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomClasse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nomClasse;
    }

    public function setNomClasse(string $nomClasse): self
    {
        $this->nomClasse = $nomClasse;

        return $this;
    }
}
