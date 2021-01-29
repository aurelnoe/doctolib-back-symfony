<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Praticien;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PraticienFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=6; $i <= 10; $i++) 
        { 
            $praticien = (new Praticien())
                ->setSpecialite("Dentiste $i")
                ->setAdresse((new Adresse())->setLibelleVoie("rue")
                                            ->setVille("marseille")
                                            ->setPays("France"))
                ->setNom("Dubois $i")
                ->setPrenom("Patrice $i")
                ->setDateInscription(new DateTime("2020-10-$i"))
                ->setEmail("adresse$i@mail.com")
                ->setTelephone("06060606$i")
                ->setPassword("Password$i");
                
            $manager->persist($praticien);
        }
        $manager->flush();
    }
}
