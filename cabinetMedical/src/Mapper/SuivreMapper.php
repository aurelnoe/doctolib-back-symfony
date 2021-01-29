<?php

namespace App\Mapper;

use App\DTO\SuivreDTO;
use App\Entity\Suivre;
use App\Entity\Patient;
use App\Entity\Praticien;
use App\Mapper\PatientMapper;
use App\Mapper\PraticienMapper;

class SuivreMapper {
    private $patientMapper;
    private $praticienMapper;

    public function __construct(PraticienMapper $praticienMapper,PatientMapper $patientMapper)
    {
        $this->patientMapper = $patientMapper;
        $this->praticienMapper = $praticienMapper;
    }
    
    public function transformeSuivreDTOToSuivreEntity(Suivre $suivre ,Patient $patient,Praticien $praticien){
        $suivre->setPatient($patient);
        $suivre->setPraticien($praticien);
        return $suivre;
    }

    public function transformeSuivreEntityToSuivreDTO(Suivre $suivre){
        $suivreDto = new SuivreDTO();
        $suivreDto->setId($suivre->getId());
        $suivreDto->setPatient($this->patientMapper->transformePatientEntityToPatientDto($suivre->getPatient()));
        $suivreDto->setPraticien($this->praticienMapper->transformePraticienEntityToPraticienDto($suivre->getPraticien()));
        return $suivreDto;
    }
}