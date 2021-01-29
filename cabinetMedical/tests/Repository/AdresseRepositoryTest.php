<?php

namespace App\tests\Repository;

use DateTime;
use App\Entity\Adresse;
use App\DataFixtures\AdresseFixture;
use App\DataFixtures\AppFixtures;
use App\Repository\AdresseRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdresseRepositoryTest extends KernelTestCase 
{
    use FixturesTrait;

    private $repository;

    protected function setUp(): void 
    {
        self::bootKernel();
        $this->repository = self::$container->get(AdresseRepository::class);
    }

    protected function tearDown(): void {
        $this->loadFixtures([AppFixtures::class]);
    }

    public function testFindBy()
    {
        $this->loadFixtures([AdresseFixture::class]);
        $adresse = $this->repository->findBy(["libelleVoie" => "1 rue longue"]);

        $this->assertCount(1, $adresse);
    }

    public function testFindAll()
    {   
        $this->loadFixtures([AdresseFixture::class]);
        //Insérer Adresse dans bdd test
        $adresses = $this->repository->findAll();

        $this->assertCount(6, $adresses);
    }

    public function testManagerPersist()
    {
        $this->loadFixtures([AppFixtures::class]);
        $adresse = (new Adresse())->setLibelleVoie("1 rue longue")
                                  ->setVille("Paris")
                                  ->setPays("France");
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($adresse);
        $manager->flush();

        $this->assertCount(1, $this->repository->findAll());
    }
}