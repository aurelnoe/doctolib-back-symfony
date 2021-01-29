<?php
namespace App\Service;

use App\DTO\SuivreDTO;
use App\Entity\Suivre;
use App\Mapper\SuivreMapper;
use App\Repository\SuivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\SuivreServiceException;

class ServiceSuivre
{
    private $suivreRepository;
    private $suivreManager;
    private $suivreMapper;

    public function __construct(SuivreRepository $suivreRepository,
                                EntityManagerInterface $suivreManager,
                                SuivreMapper $mapper) 
    {
        $this->suivreRepository = $suivreRepository;
        $this->suivreManager = $suivreManager;
        $this->suivreMapper = $mapper;
    }

    public function searchAll()
    {
        try {
            $suivres = $this->suivreRepository->findAll();
            $suivreDTOs = [];
            foreach ($suivres as $suivre) {
                $suivreDTOs[] = $this->suivreMapper->transformeSuivreEntityToSuivreDto($suivre);
            }     
            return $suivreDTOs;
        } 
        catch (DriverException $e) {
            throw new SuivreServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function getSuivreById(Suivre $id)
    {
        try {
            $suivre = $this->suivreRepository->find($id);
            return $suivre; 
        } 
        catch (DriverException $e) {
            throw new SuivreServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function delete(Suivre $id)
    {
        try {
            $suivre = $this->suivreRepository->find($id);
            $this->suivreManager->remove($suivre);
            $this->suivreManager->flush();
        } 
        catch (DriverException $e) {
            throw new SuivreServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function persist(?Suivre $suivre, SuivreDTO $suivreDto){
        try {
            $praticien = $this->praticienRepository->find($suivreDto->getPraticien()->getId());
            $patient = $this->patientRepository->find($suivreDto->getPatient()->getId());
            $suivre = $this->suivreMapper->transformeSuivreDtoToSuivreEntity($suivre,$praticien,$patient);
            $this->entityMananger->persist($suivre);
            $this->entityMananger->flush();
        }
        catch (DriverException $e) {
            throw new SuivreServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $suivre = $this->repository->find($id);
            return $this->suivreMapper->transformeSuivreEntityToSuivreDto($suivre);
        } catch(DriverException $e){
            throw new SuivreServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }
}