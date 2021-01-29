<?php

namespace App\tests\Entity;

use App\Entity\Praticien;
use App\Entity\RendezVous;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PraticienTest extends KernelTestCase 
{
    private $validator;

    protected function setUp(): void {

        self::bootKernel();

        $this->validator = self::$container->get("validator");
    }
    
    // protected function tearDown(): void {
    //     // //Monkey\tearDown();
    //     // //parent::tearDown();
    // }

    private function getPraticien(string $nom=null, string $prenom=null,\DateTime $dateInscription=null, string $email=null, string $telephone=null,string $password=null,string $specialite = null)
    {
        $praticien = (new Praticien())->setNom($nom)
                                      ->setPrenom($prenom)
                                      ->setDateInscription($dateInscription)
                                      ->setEmail($email)
                                      ->setTelephone($telephone)
                                      ->setPassword($password)
                                      ->setSpecialite($specialite);
        return $praticien;
    }

    public function testGetterAndSetterSpecialite(){

        $praticien = $this->getPraticien("tutu","toto",new \DateTime("2020-10-27"),"adresse@mail.com","0606060606","Password","chirurgien");

        $praticien->setSpecialite("chirurgien");

        $this->assertEquals("chirurgien", $praticien->getSpecialite());
    }

    public function testIsSpecialiteValid(){

        $client = $this->getPraticien("tutu","toto",new \DateTime("2020-10-27"),"adresse@mail.com","0606060606","Password","chirurgien");

        $errors = $this->validator->validate($client);

        $this->assertCount(0, $errors);
    }

    public function testRemoveRendezVous()
    {
        $user = $this->getPraticien("1987-10-27 11:15:00");
        $rendezVous = (new RendezVous())->setDateHeure(new \DateTime('2021-06-11 11:55'));
        $user->addRendezVou($rendezVous);
        $this->assertCount(1, $user->getRendezVous());
        $user->removeRendezVou($rendezVous);
        $this->assertCount(0, $user->getRendezVous());
        $this->assertEquals(null, $rendezVous->getPraticien());
    }
}