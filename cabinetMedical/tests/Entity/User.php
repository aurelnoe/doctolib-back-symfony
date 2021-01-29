<?php

namespace App\tests\Entity;

use DateTime;
use App\Entity\User;
use App\Entity\Patient;
use App\Entity\Praticien;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase 
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

    private function getUser(string $nom = null, string $prenom = null, string $dateInscription = null, string $email = null, int $telephone = null, string $password = null)
    {
        $user = (new User())->setNom($nom)
                            ->setPrenom($prenom)
                            ->setDateInscription(new \DateTime($dateInscription))
                            ->setEmail($email)
                            ->setTelephone($telephone)
                            ->setPassword($password);
        return $user;
    }

    public function testGetterAndSetterNom(){

        $user = $this->getUser("toto");

        $user->setNom("DUPONT");

        $this->assertEquals("DUPONT", $user->getNom());
    }

    public function testGetterAndSetterPrenom(){

        $user = $this->getUser("tutu","toto");

        $user->setPrenom("David");

        $this->assertEquals("David", $user->getPrenom());
    }

    public function testGetterAndSetterDateInscription(){

        $user = $this->getUser("tutu","toto","2020-10-27");

        $user->setDateInscription(new \DateTime("2020-10-27"));

        $this->assertEquals("2020-10-27", $user->getDateInscription()->format('Y-m-d'));
    }

    public function testGetterAndSetterEmail(){

        $user = $this->getUser("tutu","toto","2020-10-27","adresse@mail.com");

        $user->setEmail("adresse@mail.com");

        $this->assertEquals("adresse@mail.com", $user->getEmail());
    }

    public function testGetterAndSetterTelephone(){

        $user = $this->getUser("tutu","toto","2020-10-27","adresse@mail.com",'0606060606');

        $user->setTelephone('0606060606');

        $this->assertEquals('0606060606', $user->getTelephone());
    }

    public function testGetterAndSetterPassword(){

        $user = $this->getUser("tutu","toto","2020-10-27","adresse@mail.com",'0606060606',"Password");

        $user->setPassword("Password");

        $this->assertEquals("Password", $user->getPassword());
    }

    public function testIsNomValid(){

        $client = $this->getUser("DUPOND");

        $errors = $this->validator->validate($client);

        $this->assertCount(0, $errors);
    }

    public function testIsPrenomValid(){

        $client = $this->getUser("DUPOND", "David");

        $errors = $this->validator->validate($client);

        $this->assertCount(0, $errors);
    }

    public function testIsEmailDateInscription(){

        $client = $this->getUser("DUPOND", "David","2020-12-16");

        $errors = $this->validator->validate($client);

        $this->assertCount(0, $errors);
    }

    public function testIsEmailValid(){

        $client = $this->getUser("DUPOND","David","2020-12-16","adresse@mail.com");

        $errors = $this->validator->validate($client);

        $this->assertCount(0, $errors);
    }

    public function testIsTelephoneValid(){

        $client = $this->getUser("DUPOND", "David","2020-12-16","adresse@mail.com",'0606060606');

        $errors = $this->validator->validate($client);

        $this->assertCount(0, $errors);
    }

    public function testIsPasswordValid(){

        $client = $this->getUser("DUPOND", "David","2020-12-16","adresse@mail.com",'0606060606',"Password");

        $errors = $this->validator->validate($client);

        $this->assertCount(0, $errors);
    }

    

    public function testNotValidLengthMiniNom(){

        $user = $this->getUser("DU");

        $errors = $this->validator->validate($user);

        $this->assertCount(1, $errors);

        $this->assertEquals("Le nom doit faire plus de 3 caractères !", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidLengthMinNom");
    }

    public function testNotValidLengthMaxNom(){

        $client = $this->getUser("testtttttttttttttttttttttttt","David");

        $errors = $this->validator->validate($client);

        $this->assertCount(1, $errors);

        $this->assertEquals("Le nom ne peut pas faire plus de 20 caractères !", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidLengthMaxNom");
    }

    public function testNotValidLengthMiniPrenom(){

        $user = $this->getUser("DURAND","Da");

        $errors = $this->validator->validate($user);

        $this->assertCount(1, $errors);

        $this->assertEquals("Le prénom doit faire plus de 3 caractères !", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidLengthMinPrenom");
    }

    public function testNotValidLengthMaxPrenom(){

        $client = $this->getUser("test","Daviiiiiiiiiiiiiiiiiiiiiiiiiiiiiiid");

        $errors = $this->validator->validate($client);

        $this->assertCount(1, $errors);

        $this->assertEquals("Le prénom ne peut pas faire plus de 20 caractères !", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidLengthMaxPrenom");
    }

    
    public function testNotValidLengthMiniTelephone(){

        $user = $this->getUser("DURAND","David",'06');

        $errors = $this->validator->validate($user);

        $this->assertCount(1, $errors);

        $this->assertEquals("Le numéro de téléphone doit faire plus de 3 chiffres !", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidLengthMinTelephone");
    }

    public function testNotValidLengthMaxTelephone(){

        $user = $this->getUser("test","David",'000000000000000000000000000000000000');

        $errors = $this->validator->validate($user);

        $this->assertCount(1, $errors);

        $this->assertEquals("Le numéro de téléphone ne peut pas faire plus de 20 chiffres !", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidLengthMaxTelephone");
    }

    public function testRemovePatient(){
        $user = $this->getUser("Durand","David","2021-06-11 11:55","rbre@live.fr", '0601020304', "Password");
        $patient = (new Patient())->setDateInscription(new \DateTime('2021-06-11 11:55'));
        $user->addPatient($patient);
        $this->assertCount(1, $user->getPatient());
        $user->removePatient($patient);
        $this->assertCount(0, $user->getPatient());
        $this->assertEquals(null, $patient->getPatient());
    }

    public function testRemovePraticien(){
        $user = $this->getUser("Durand","David","2021-06-11 11:55","r.bre@live.fr", '0601020304', "Password");
        $praticien = (new Praticien())->setDateInscription(new \DateTime('2021-06-11 11:55'));
        $user->addPraticien($praticien);
        $this->assertCount(1, $user->getPraticien());
        $user->removePraticien($praticien);
        $this->assertCount(0, $user->getPraticien());
        $this->assertEquals(null, $praticien->getPraticien());
    }
}