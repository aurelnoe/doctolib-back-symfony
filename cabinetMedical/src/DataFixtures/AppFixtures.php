<?php

namespace App\DataFixtures;

use App\Repository\PatientRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $repository;

    public function __construct(PatientRepository $repository){
        $this->repository = $repository;
    }

    public function load(ObjectManager $manager)
    {
        $patients = $this->repository->findAll();
        foreach ($patients as $c) {
            $manager->remove($c);
        }
        $manager->flush();

        $praticiens = $this->repository->findAll();
        foreach ($praticiens as $c) {
            $manager->remove($c);
        }
        $manager->flush();

        $rendezVous = $this->repository->findAll();
        foreach ($rendezVous as $c) {
            $manager->remove($c);
        }
        $manager->flush();

        $adresses = $this->repository->findAll();
        foreach ($adresses as $c) {
            $manager->remove($c);
        }
        $manager->flush();
    }
}
