<?php

namespace App\tests\Repository;

use DateTime;
use App\Entity\Patient;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\PatientFixture;
use App\Repository\PatientRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientRepositoryTest extends KernelTestCase 
{
    use FixturesTrait;

    private $repository;

    protected function setUp(): void 
    {
        self::bootKernel();
        $this->repository = self::$container->get(PatientRepository::class);
    }

    protected function tearDown(): void {
        $this->loadFixtures([AppFixtures::class]);
    }

    public function testFindBy()
    {
        $this->loadFixtures([PatientFixture::class]);
        $patient = $this->repository->findBy(["prenom" => "David 1"]);
        //$dateNaissance = (new Patient())->setDateNaissance(new \DateTime('2021-06-11')->format('Y-m-d'));
        // array_map('strtotime',$patient);
        // $this->dateNaissance->format('Y-m-d');
        // $this->dateInscription->format('Y-m-d');

        $this->assertCount(1, $patient);
    }

    public function testFindAll()
    {   
        $this->loadFixtures([PatientFixture::class]);
        //Insérer patient dans bdd test
        $patients = $this->repository->findAll();

        $this->assertCount(6, $patients);
    }

    public function testFindById()
    {
        $this->loadFixtures([PatientFixture::class]);

        $patient = $this->repository->findById(1);

        $this->assertCount(1, $patient);
    }

    public function testManagerPersist()
    {
        $this->loadFixtures([AppFixtures::class]);
        $patient = (new Patient())->setDateNaissance(new \DateTime('1987-10-27'))
                                  ->setNom('Durand')
                                  ->setPrenom('David')
                                  ->setDateInscription(new \DateTime('2020-12-20'))
                                  ->setEmail('test@mail.com')
                                  ->setTelephone('0607080910')
                                  ->setPassword('Password');

        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($patient);
        $manager->flush();

        $this->assertCount(1, $this->repository->findAll());
    }
}