<?php

namespace App\Mapper;

use App\DTO\AdresseDTO;
use App\Entity\Adresse;

class AdresseMapper 
{
    public function transformeAdresseDTOToAdresseEntity(AdresseDTO $adresseDto, Adresse $adresse){
        $adresse->setId($adresseDto->getId());
        $adresse->setDenomination($adresseDto->getDenomination());
        $adresse->setlibelleVoie($adresseDto->getlibelleVoie());
        $adresse->setVille($adresseDto->getVille());
        $adresse->setPays($adresseDto->getPays());
        return $adresse;
    }

    public function transformeAdresseEntityToAdresseDTO(Adresse $adresse){
        $adresseDto = new AdresseDTO();
        $adresseDto->setId($adresse->getId());
        $adresseDto->setDenomination($adresse->getDenomination());
        $adresseDto->setlibelleVoie($adresse->getlibelleVoie());
        $adresseDto->setVille($adresse->getVille());
        $adresseDto->setPays($adresse->getPays());
        return $adresseDto;
    }
}