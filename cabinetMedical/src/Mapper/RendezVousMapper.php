<?php

namespace App\Mapper;

use App\Entity\Patient;
use App\Entity\Praticien;
use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use App\Mapper\PatientMapper;
use App\Mapper\PraticienMapper;

class RendezVousMapper {

    private $patientMapper;
    private $praticienMapper;

    public function __construct(PraticienMapper $praticienMapper,PatientMapper $patientMapper)
    {
        $this->patientMapper = $patientMapper;
        $this->praticienMapper = $praticienMapper;
    }

    public function transformeRendezVousDTOToRendezVousEntity(RendezVousDTO $rendezVousDto, RendezVous $rendezVous,Praticien $praticien, Patient $patient){
        $rendezVous->setDateHeure($rendezVousDto->getDateHeure());
        $rendezVous->setPatient($patient);
        $rendezVous->setPraticien($praticien);
        return $rendezVous;
    }

    public function transformeRendezVousEntityToRendezVousDTO(RendezVous $rendezVous){
        $rendezVousDto = new RendezVousDTO();
        $rendezVousDto->setId($rendezVous->getId());
        $rendezVousDto->setDateHeure($rendezVous->getDateHeure());
        $rendezVousDto->setPatient($this->patientMapper->transformePatientEntityToPatientDto($rendezVous->getPatient()));
        $rendezVousDto->setPraticien($this->praticienMapper->transformePraticienEntityToPraticienDto($rendezVous->getPraticien()));
        return $rendezVousDto;
    }
}