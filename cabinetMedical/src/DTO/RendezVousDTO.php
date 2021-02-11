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
     * @var string
     */
    private $dateDebut;

    /**
     * @OA\Property(
     *      type="string",
     *      format="datetime"
     * )
     *
     * @var string
     */
    private $dateFin;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $motif;

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
     * Get the value of dateDebut
     */ 
    public function getDateDebut():?string
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of dateDebut
     *
     * @return  self
     */ 
    public function setDateDebut(?string $dateDebut):self
    {
        $this->dateDebut = $dateDebut;

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

    /**
     * Get )
     *
     * @return  string
     */ 
    public function getDateFin():?string
    {
        return $this->dateFin;
    }

    /**
     * Set )
     *
     * @param  string  $dateFin  )
     *
     * @return  self
     */ 
    public function setDateFin(?string $dateFin):self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get the value of motif
     *
     * @return  string
     */ 
    public function getMotif():?string
    {
        return $this->motif;
    }

    /**
     * Set the value of motif
     *
     * @param  string  $motif
     *
     * @return  self
     */ 
    public function setMotif(?string $motif):self
    {
        $this->motif = $motif;

        return $this;
    }
}