<?php
namespace App\Service;

use App\DTO\AdresseDTO;
use App\Entity\Adresse;
use App\Mapper\AdresseMapper;
use App\Repository\AdresseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\AdresseServiceException;

class ServiceAdresse
{
    private $adresseRepository;
    private $adresseManager;
    private $adresseMapper;

    public function __construct(AdresseRepository $adresseRepository,
                                EntityManagerInterface $adresseManager,
                                AdresseMapper $mapper) 
    {
        $this->adresseRepository = $adresseRepository;
        $this->adresseManager = $adresseManager;
        $this->adresseMapper = $mapper;
    }

    public function searchAll()
    {
        try {
            $adresses = $this->adresseRepository->findAll();
            $adresseDTOs = [];
            foreach ($adresses as $adresse) {
                $adresseDTOs[] = $this->adresseMapper->transformeAdresseEntityToAdresseDto($adresse);
            }     
            return $adresseDTOs;
        } 
        catch (DriverException $e) {
            throw new AdresseServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function delete(Adresse $id)
    {
        try {
            $adresse = $this->adresseRepository->find($id);
            $this->adresseManager->remove($adresse);
            $this->adresseManager->flush();
        } 
        catch (DriverException $e) {
            throw new AdresseServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function persist(?Adresse $adresse,AdresseDTO $adresseDto){
        try {
            $adresse = $this->adresseMapper->transformeAdresseDtoToAdresseEntity($adresseDto, $adresse);
            $this->adresseManager->persist($adresse);
            $this->adresseManager->flush();
        }
        catch (DriverException $e) {
            throw new AdresseServiceException("Un problème technique est survenu", $e->getCode());
        }
    }

    public function searchById(int $id)
    {
        try {
            $adresse = $this->repository->find($id);
            return $this->adresseMapper->transformeAdresseEntityToAdresseDto($adresse);
        } catch(DriverException $e){
            throw new AdresseServiceException("Un problème est technique est servenu. Veuilllez réessayer ultérieurement.", $e->getCode());
        }
    }
}