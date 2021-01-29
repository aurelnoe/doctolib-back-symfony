<?php

namespace App\tests\Repository;

use DateTime;
use App\Entity\RendezVous;
use App\DataFixtures\RendezVousFixture;
use App\DataFixtures\AppFixtures;
use App\Repository\RendezVousRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RendezVousRepositoryTest extends KernelTestCase 
{
    use FixturesTrait;

    private $repository;

    protected function setUp(): void 
    {
        self::bootKernel();
        $this->repository = self::$container->get(RendezVousRepository::class);
    }

    protected function tearDown(): void {
        $this->loadFixtures([AppFixtures::class]);
    }
}