<?php

namespace App\Entity;

use App\Repository\SuivreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuivreRepository::class)
 */
class Suivre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Praticien::class, inversedBy="suivres")
     */
    private $praticien;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="suivres")
     */
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPraticien(): ?Praticien
    {
        return $this->praticien;
    }

    public function setPraticien(?Praticien $praticien): self
    {
        $this->praticien = $praticien;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
