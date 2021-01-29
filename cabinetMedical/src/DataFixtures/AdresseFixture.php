<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AdresseFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <= 5; $i++) { 
            $adresse = (new Adresse())->setlibelleVoie("$i rue longue")
                                    ->setVille("Paris $i")
                                    ->setPays("France $i");
            $manager->persist($adresse);
                                
        }
        $manager->flush();
    }
}