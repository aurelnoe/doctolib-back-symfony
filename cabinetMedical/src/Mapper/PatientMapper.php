<?php

namespace App\Mapper;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PatientMapper {

    private $adresseMapper;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function transformePatientDtoToPatientEntity(PatientDTO $patientDto,Patient $patient)
    {
        $hash = $this->encoder->encodePassword($patient, $patientDto->getPassword());
        $patient->setId($patientDto->getId());
        $patient->setNom($patientDto->getNom());
        $patient->setPrenom($patientDto->getPrenom());
        $patient->setDateInscription(new \DateTime($patientDto->getDateInscription()));
        $patient->setEmail($patientDto->getEmail());
        $patient->setTelephone($patientDto->getTelephone());
        $patient->setPassword($hash);
        //$patient->setRole($patientDto->getRole());
        $patient->setDateNaissance(new \DateTime($patientDto->getDateNaissance()));
        return $patient;
    }

    public function transformePatientEntityToPatientDto(Patient $patient) 
    {
        $patientDto = new PatientDTO();
        $patientDto->setId($patient->getId());
        $patientDto->setNom($patient->getNom());
        $patientDto->setPrenom($patient->getPrenom());
        $patientDto->setDateInscription($patient->getDateInscription()->format('Y-m-d'));
        $patientDto->setEmail($patient->getEmail());
        $patientDto->setTelephone($patient->getTelephone());
        $patientDto->setRole("patient");
        //$patientDto->setPassword($patient->getPassword());
        $patientDto->setDateNaissance($patient->getDateNaissance()->format('Y-m-d'));
        return $patientDto;
    }
}