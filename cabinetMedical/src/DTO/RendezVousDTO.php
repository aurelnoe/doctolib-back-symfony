<?php

namespace App\DTO;

use DateTimeInterface;
use App\DTO\PatientDTO;
use App\DTO\PraticienDTO;
Use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class RendezVousDTO 
{
    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *      type="string",
     *      format="datetime"
     * )
     *
     * @var \DateTimeInterface
     */
    private $dateHeure;

    /**
     * @OA\Property(type="object")
     *
     * @var PatientDTO
     */
    private $patient;

    /**
     * @OA\Property(type="object")
     *
     * @var PraticienDTO
     */
    private $praticien;

    /**
     * Get the value of id
     */ 
    public function getId():?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of dateHeure
     */ 
    public function getDateHeure():?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    /**
     * Set the value of dateHeure
     *
     * @return  self
     */ 
    public function setDateHeure(?\DateTimeInterface $dateHeure):self
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    /**
     * Get the value of patient
     */ 
    public function getPatient():?PatientDTO
    {
        return $this->patient;
    }

    /**
     * Set the value of patient
     *
     * @return  self
     */ 
    public function setPatient(?PatientDTO $patient):self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get the value of praticien
     */ 
    public function getPraticien():?PraticienDTO
    {
        return $this->praticien;
    }

    /**
     * Set the value of praticien
     *
     * @return  self
     */ 
    public function setPraticien(?PraticienDTO $praticien):self
    {
        $this->praticien = $praticien;

        return $this;
    }
}