<?php

namespace App\tests\Repository;

use DateTime;
use App\Entity\Adresse;
use App\Entity\Praticien;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\PraticienFixture;
use App\Repository\PraticienRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PraticienRepositoryTest extends KernelTestCase 
{
    use FixturesTrait;

    private $repository;

    protected function setUp(): void 
    {
        self::bootKernel();
        $this->repository = self::$container->get(PraticienRepository::class);
    }

    protected function tearDown(): void {
        $this->loadFixtures([AppFixtures::class]);
    }

    public function testFindBy()
    {
        $this->loadFixtures([PraticienFixture::class]);
        $praticien = $this->repository->findBy(["specialite" => "Dentiste 6"]);

        $this->assertCount(1, $praticien);
    }

    public function testFindAll()
    {   
        $this->loadFixtures([PraticienFixture::class]);
        //Insérer Praticien dans bdd test
        $praticiens = $this->repository->findAll();

        $this->assertCount(5, $praticiens);
    }

    public function testManagerPersist()
    {
        $this->loadFixtures([AppFixtures::class]);
        $praticien = (new Praticien())->setSpecialite('chirurgien')
                                    ->setAdresse((new Adresse())->setLibelleVoie("rue")
                                            ->setVille("marseille")
                                            ->setPays("France"))
                                    ->setNom("Dubois")
                                    ->setPrenom("Patrice")
                                    ->setDateInscription(new \DateTime('2020-12-20'))
                                    ->setEmail("email@mailpro.com")
                                    ->setTelephone("0606060606")
                                    ->setPassword("Password");                            
                                    
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($praticien);
        $manager->flush();

        $this->assertCount(1, $this->repository->findAll());
    }
}