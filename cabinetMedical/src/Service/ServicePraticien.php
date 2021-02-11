<?php
namespace App\Service;

use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use App\Mapper\PraticienMapper;
use App\Repository\AdresseRepository;
use App\Repository\PraticienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\PraticienServiceException;

class ServicePraticien
{
    private $praticienRepository;
    private $adresseRepository;
    private $entityManager;
    private $praticienMapper;

    public function __construct(PraticienRepository $praticienRepository,
                                AdresseRepository $adresseRepository,
                                EntityManagerInterface $entityManager,
                                PraticienMapper $mapper) 
    {
        $this->praticienRepository = $praticienRepository;
        $this->adresseRepository = $adresseRepository;
        $this->entityManager = $entityManager;
        $this->praticienMapper = $mapper;
    }

    public function searchAll()
    {
        try {
            $praticiens = $this->praticienRepository->findAll();
            $praticienDTOs = [];
            foreach ($praticiens as $praticien) {
                $praticienDTOs[] = $this->praticienMapper->transformePraticienEntityToPraticienDto($praticien);
            }     
            return $praticienDTOs;
        }
        catch (DriverException $e) {
            throw new PraticienServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function delete(Praticien $praticien, PraticienDTO $praticienDTO)
    {
        try {
            $praticien = $this->praticienRepository->find($praticienDTO->getId());
            $this->entityManager->remove($praticien);
            $this->entityManager->flush();
        } 
        catch (DriverException $e) {
            throw new PraticienServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function persist(?Praticien $praticien,PraticienDTO $praticienDto){
        try {
            $adresse = $this->adresseRepository->find($praticienDto->getAdresse()->getId());
            $praticien = $this->praticienMapper->transformePraticienDtoToPraticienEntity($praticienDto,$praticien,$adresse);
            $this->entityManager->persist($praticien);
            $this->entityManager->flush();
        }
        catch (DriverException $e) {
            throw new PraticienServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $praticien = $this->praticienRepository->find($id);
            return $this->praticienMapper->transformePraticienEntityToPraticienDto($praticien);
        } catch(DriverException $e){
            throw new PraticienServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function findPraticiensByVille(string $ville)
    {
        try {
            $praticiens = $this->praticienRepository->findPraticiensByVille($ville);
            
            $praticienDTOs = [];
            //dd($praticiens);
            foreach ($praticiens as $praticien) {
                $praticienDTOs[] = $this->praticienMapper->transformePraticienEntityToPraticienDto($praticien);
            } 
            //var_dump($praticiens);
            //var_dump($praticiens[0]);
            return $praticienDTOs;

        } 
        catch(DriverException $e){
            throw new PraticienServiceException($e->getMessage(), $e->getCode());
        }
    }
}