<?php

namespace App\tests\Entity;

use App\Entity\Adresse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdresseTest extends KernelTestCase 
{
    private $validator;

    protected function setUp(): void {

        self::bootKernel();

        $this->validator = self::$container->get("validator");
    }

    private function getAdresse(string $libelleVoie = null, string $ville = null, string $pays = null)
    {
        $adresse = (new Adresse())->setLibelleVoie($libelleVoie)
                                  ->setVille($ville)
                                  ->setPays($pays);
        return $adresse;
    }

    public function testGetterAndSetterLibelleVoie(){

       $adresse = $this->getAdresse("rue du pont");

        $adresse->setLibelleVoie("rue du pont");

        $this->assertEquals("rue du pont", $adresse->getLibelleVoie());
    }

    public function testGetterAndSetterVille(){

        $adresse = $this->getAdresse("rue du pont","Paris");

        $adresse->setVille("Paris");

        $this->assertEquals("Paris", $adresse->getVille());
    }

    public function testGetterAndSetterPays(){

        $adresse = $this->getAdresse("rue du pont","Paris","France");

        $adresse->setPays("France");

        $this->assertEquals("France", $adresse->getPays());
    }

    public function testIsLibelleVoieValid(){

        $adresse = $this->getAdresse("rue du pont");

        $errors = $this->validator->validate($adresse);

        $this->assertCount(0, $errors);
    }

    public function testIsVilleValid(){

        $adresse = $this->getAdresse("rue du pont","Paris");

        $errors = $this->validator->validate($adresse);

        $this->assertCount(0, $errors);
    }

    public function testIsPaysValid(){

        $adresse = $this->getAdresse("rue du pont","Paris","France");

        $errors = $this->validator->validate($adresse);

        $this->assertCount(0, $errors);
    }
}