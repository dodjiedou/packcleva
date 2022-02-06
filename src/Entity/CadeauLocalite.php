<?php

namespace App\Entity;

use App\Repository\CadeauLocaliteRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Cadeau;

/**
 * @ORM\Entity(repositoryClass=CadeauLocaliteRepository::class)
 */
class CadeauLocalite extends Cadeau
{
     
    

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomLocalite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLocalite(): ?string
    {
        return $this->nomLocalite;
    }

    public function setNomLocalite(string $nomLocalite): self
    {
        $this->nomLocalite = $nomLocalite;

        return $this;
    }
}
