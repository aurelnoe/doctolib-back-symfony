<?php

namespace App\Mapper;

use App\Entity\Adresse;
use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use App\Mapper\AdresseMapper;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PraticienMapper
{
    private $adresseMapper;
    private $encoder;

    public function __construct(AdresseMapper $adresseMapper, UserPasswordEncoderInterface $encoder)
    {
        $this->adresseMapper = $adresseMapper;
        $this->encoder = $encoder;
    }

    public function transformePraticienDtoToPraticienEntity(PraticienDTO $praticienDto,Praticien $praticien,Adresse $adresse)
    {
        $hash=$this->encoder->encodePassword($praticien, $praticienDto->getPassword());
        $praticien->setId($praticienDto->getId());
        $praticien->setNom($praticienDto->getNom());
        $praticien->setPrenom($praticienDto->getPrenom());
        $praticien->setDateInscription($praticienDto->getDateInscription());
        $praticien->setEmail($praticienDto->getEmail());
        $praticien->setTelephone($praticienDto->getTelephone());
        $praticien->setPassword($hash);
        $praticien->setSpecialite($praticienDto->getSpecialite());
        $praticien->setAdresse($adresse);
        return $praticien;
    }

    public function transformePraticienEntityToPraticienDto(Praticien $praticien) 
    {
        $praticienDto = new PraticienDTO();
        $praticienDto->setId($praticien->getId());
        $praticienDto->setNom($praticien->getNom());
        $praticienDto->setPrenom($praticien->getPrenom());
        $praticienDto->setDateInscription($praticien->getDateInscription());
        $praticienDto->setEmail($praticien->getEmail());
        $praticienDto->setTelephone($praticien->getTelephone());
        // $praticienDto->setPassword($praticien->getPassword()); PAS DE MDP DANS DAO !!
        $praticienDto->setSpecialite($praticien->getSpecialite());
        $praticienDto->setAdresse($this->adresseMapper->transformeAdresseEntityToAdresseDTO($praticien->getAdresse()));
        return $praticienDto;
    }
}