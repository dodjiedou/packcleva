<?php

namespace App\Entity;

use App\Repository\CadeauRangOccupeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CadeauRangOccupeRepository::class)
 */
class CadeauRangOccupe extends Cadeau
{
    
   

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $rang;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRang(): ?string
    {
        return $this->rang;
    }

    public function setRang(string $rang): self
    {
        $this->rang = $rang;

        return $this;
    }
}
