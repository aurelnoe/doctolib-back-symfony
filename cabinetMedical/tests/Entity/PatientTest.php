<?php

namespace App\tests\Entity;

use App\Entity\Patient;
use App\Entity\RendezVous;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase 
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

    private function getPatient(string $nom=null, string $prenom=null, \DateTime $dateInscription=null, string $email=null, string $telephone=null,string $password=null,\DateTime $dateNaissance = null)
    {
        $patient = (new Patient())->setNom($nom)
                                    ->setPrenom($prenom)
                                    ->setDateInscription($dateInscription)
                                    ->setEmail($email)
                                    ->setTelephone($telephone)
                                    ->setPassword($password)
                                    ->setDateNaissance($dateNaissance);
        
        return $patient;
    }
    
    public function testGetterAndSetterDateNaissance(){

        $patient = $this->getPatient("tutu","toto",new \DateTime("2020-12-12"),"adresse@mail.com","0606060606","Password",new \DateTime("1987-10-27"));

        $patient->setDateNaissance(new \DateTime("1987-10-27"));

        $this->assertEquals(new \DateTime("1987-10-27"), $patient->getDateNaissance());
    }

    public function testIsDateNaissanceValid(){

        $patient = $this->getPatient("DUPOND", "David",new \DateTime("2020-12-16"),"adresse@mail.com","0606060606","Password",new \DateTime("1987-10-27"));

        $errors = $this->validator->validate($patient);

        $this->assertCount(0, $errors);
    }

    public function testRemoveRendezVous()
    {
        $user = $this->getPatient(("1987-10-27 11:15:00"));
        $rendezVous = (new RendezVous())->setDateHeure(new \DateTime("2021-06-11 11:55"));
        $user->addRendezVou($rendezVous);
        $this->assertCount(1, $user->getRendezVous());
        $user->removeRendezVou($rendezVous);
        $this->assertCount(0, $user->getRendezVous());
        $this->assertEquals(null, $rendezVous->getPatient());
    }
}