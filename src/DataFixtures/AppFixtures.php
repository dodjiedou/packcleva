<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Vaccin;
use App\Entity\Maladie;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $malaria = new Maladie();
        $malaria->setNom('Malaria');
        $manager->persist($malaria);

        $cancer = new Maladie();
        $cancer->setNom('Cancer');
        $manager->persist($cancer);

        $bilharziose = new Maladie();
        $bilharziose->setNom('Bilharziose');
        $manager->persist($bilharziose);

        $tripanosomiase = new Maladie();
        $tripanosomiase->setNom('Tripanosomiase');
        $manager->persist($tripanosomiase);
    
        $antitetanique = new Vaccin();
        $antitetanique->setNom('Antitetanique');
        $manager->persist($antitetanique);

        $antirougioleux = new Vaccin();
        $antirougioleux->setNom('Antirougioleux');
        $manager->persist($antirougioleux);

        $poliomyélite = new Vaccin();
        $poliomyélite->setNom('Poliomyélite');
        $manager->persist($poliomyélite);

        $manager->flush();
    }
}
