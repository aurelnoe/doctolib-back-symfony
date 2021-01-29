<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PatientFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <= 5; $i++) { 
            $patient = (new Patient())->setDateNaissance(new \DateTime("198$i-10-10"))
                                    ->setNom("Dupond $i")
                                    ->setPrenom("David $i")
                                    ->setDateInscription(new \DateTime('2020-10-10'))
                                    ->setEmail("adresse$i@promail.com")
                                    ->setTelephone("060606060")
                                    ->setPassword("Password$i");

            $manager->persist($patient);
        }
        $manager->flush();
    }
}
