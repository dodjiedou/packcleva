<?php

namespace App\Entity;

use App\Repository\CadeauAgeRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=CadeauAgeRepository::class)
 */
class CadeauAge extends Cadeau
{
     

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }
}
