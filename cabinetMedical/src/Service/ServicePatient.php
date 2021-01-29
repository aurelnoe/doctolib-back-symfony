<?php
namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\PatientServiceException;

class ServicePatient
{
    private $patientRepository;
    private $patientManager;
    private $patientMapper;
    private $passwordEncoder;

    public function __construct(PatientRepository $patientRepository,
                                EntityManagerInterface $patientManager,
                                PatientMapper $mapper) 
    {
        $this->patientRepository = $patientRepository;
        $this->patientManager = $patientManager;
        $this->patientMapper = $mapper;
        //$this->passwordEncoder = $passwordEncoder;
    }

    public function searchAll()
    {
        try {
            $patients = $this->patientRepository->findAll();
            $patientDTOs = [];
            foreach ($patients as $patient) {
                $patientDTOs[] = $this->patientMapper->transformePatientEntityToPatientDto($patient);
            }     
            return $patientDTOs;
        } 
        catch (DriverException $e) {
            throw new PatientServiceException($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Patient $id)
    {
        try {
            $patient = $this->patientRepository->find($id);
            $this->patientManager->remove($patient);
            $this->patientManager->flush();
        } 
        catch (DriverException $e) {
            throw new PatientServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function persist(?Patient $patient,PatientDTO $patientDto){
        try {
            $patient->setDateInscription(new \DateTime(date('Y-m-d')));
            // $patient->setPassword(
            //     $this->passwordEncoder->encodePassword(
            //         $patient,
            //         $form->get('password')->getData()
            //     )
            // );
            $patient = $this->patientMapper->transformePatientDtoToPatientEntity($patientDto, $patient);
            $this->patientManager->persist($patient);
            $this->patientManager->flush();
        }
        catch (DriverException $e) {
            throw new PatientServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $patient = $this->patientRepository->find($id);
            return $this->patientMapper->transformePatientEntityToPatientDto($patient);
        } catch(DriverException $e){
            throw new PatientServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }
}