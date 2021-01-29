<?php

namespace App\tests\Entity;

use DateTime;
use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RendezVousTest extends KernelTestCase 
{
    private $validator;

    protected function setUp(): void 
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getRendezVous(\DateTime $dateHeure = null)
    {
        $rendezVous = (new RendezVous())->setDateHeure($dateHeure);
        return $rendezVous;
    }

    public function testGetterAndSetterDateHeure(){

        $rendezVous = $this->getRendezVous(new \DateTime("2020-10-27 11:15:00"));

        $rendezVous->setDateHeure(new \DateTime("1987-10-27 11:15:00"));

        $this->assertEquals("1987-10-27 11:15:00", $rendezVous->getDateHeure()->format('Y-m-d H:i:s'));
    }

    public function testIsDateHeureValid(){

        $rendezVous = $this->getRendezVous(new \DateTime("1987-10-27 11:15:00"));

        $errors = $this->validator->validate($rendezVous);

        $this->assertCount(0, $errors);
    }
}