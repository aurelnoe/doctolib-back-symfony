<?php
namespace App\Service;

use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use App\Mapper\RendezVousMapper;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\RendezVousServiceException;

class ServiceRendezVous
{
    private $rendezVousRepository;
    private $rendezVousManager;
    private $rendezVousMapper;

    public function __construct(RendezVousRepository $rendezVousRepository,
                                EntityManagerInterface $rendezVousManager,
                                RendezVousMapper $mapper) 
    {
        $this->rendezVousRepository = $rendezVousRepository;
        $this->rendezVousManager = $rendezVousManager;
        $this->rendezVousMapper = $mapper;
    }

    public function searchAll()
    {
        try {
            $rendezVouss = $this->rendezVousRepository->findAll();
            $rendezVousDTOs = [];
            foreach ($rendezVouss as $rendezVous) {
                $rendezVousDTOs[] = $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
            }     
            return $rendezVousDTOs;
        } 
        catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function getRendezVousById(RendezVous $id)
    {
        try {
            $rendezVous = $this->rendezVousRepository->find($id);
            return $rendezVous; 
        } 
        catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function delete(RendezVous $id)
    {
        try {
            $rendezVous = $this->rendezVousRepository->find($id);
            $this->rendezVousManager->remove($rendezVous);
            $this->rendezVousManager->flush();
        } 
        catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function persist(?RendezVous $rendezVous,RendezVousDTO $rendezVousDto){
        try {
            $patient = $this->patientRepository->find($rendezVousDto->getPatient()->getId());
            $praticien = $this->praticienRepository->find($rendezVousDto->getPraticien()->getId());
            $rendezVous = $this->rendezVousMapper->transformeRendezVousDtoToRendezVousEntity($rendezVousDto, $rendezVous,$praticien,$patient);
            $this->entityMananger->persist($rendezVous);
            $this->entityMananger->flush();
        }
        catch (DriverException $e) {
            throw new RendezVousServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $rendezVous = $this->repository->find($id);
            return $this->rendezVousMapper->transformeRendezVousEntityToRendezVousDto($rendezVous);
        } catch(DriverException $e){
            throw new RendezVousServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }
}