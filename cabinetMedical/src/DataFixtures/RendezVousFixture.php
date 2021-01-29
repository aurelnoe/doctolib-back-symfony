<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\Praticien;
use App\Entity\RendezVous;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RendezVousFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i <= 6; $i++) 
        { 
            $rendezVous = (new RendezVous())->setDateHeure(new \DateTime("2020-12-12 $i:00:00"))
                                            ->setPatient((new Patient())->setDateNaissance(new \DateTime("198$i-10-10"))
                                                                        ->setNom("Dupond $i")
                                                                        ->setPrenom("David $i")
                                                                        ->setDateInscription(new \DateTime('2020-10-10'))
                                                                        ->setEmail("adresse$i@promail.com")
                                                                        ->setTelephone("060606060$i")
                                                                        ->setPassword("Password$i"))
                                            ->setPraticien((new Praticien())->setNom("Dubois $i")
                                                                        ->setPrenom("Patrice $i")
                                                                        ->setDateInscription(new DateTime("2020-10-$i"))
                                                                        ->setEmail("adresse$i@mail.com")
                                                                        ->setTelephone("06060606$i")
                                                                        ->setPassword("Password$i"));

            $manager->persist($rendezVous);
        }
        $manager->flush();
    }
}
