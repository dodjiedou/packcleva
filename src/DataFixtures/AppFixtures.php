<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Vaccin;
use App\Entity\Maladie;
use App\Entity\Beneficiaire;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

    $faker = Faker\Factory::create('fr_FR');
    $populator->addEntity(Beneficiaire::class, 30);
    $insertedPKs = $populator->execute(); 
    $faker = Faker\Factory::create('fr_FR');

        // créations des beneficiaires
        $beneficiaire = [];
        for ($i=0; $i < 30; $i++) {
            $beneficiaire[$i] = new Beneficiaire();
            $beneficiaire[$i]
               ->setNom($faker->name)
                ->setPremon($faker->siret)
                ->setReference($faker->numberBetween(111111, 999999))
                ->setContactName($faker->name)
                ->setAddress($faker->address)
            ;
            $em->persist($shops[$i]);
        }     
        
        //$manager->persist($malaria);
       // $manager->flush();
    }
}
