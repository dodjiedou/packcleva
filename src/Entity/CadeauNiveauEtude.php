<?php

namespace App\Entity;

use App\Repository\CadeauNiveauEtudeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CadeauNiveauEtudeRepository::class)
 */
class CadeauNiveauEtude extends Cadeau
{
     
   

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $niveauEtude;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(string $niveauEtude): self
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }
}
