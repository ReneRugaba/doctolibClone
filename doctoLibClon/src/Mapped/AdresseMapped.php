<?php

namespace App\Mapped;

use App\DTO\AdresseDto;
use App\Entity\Adresse;

class AdresseMapped{

    public function transformeAdresseDtoToAdresse(AdresseDto $adresseDto):Adresse
    {
        return (new Adresse)->setNumRue($adresseDto->getNumRue())
                            ->setRue($adresseDto->getRue())
                            ->setCodePostal($adresseDto->getCodePostal())
                            ->setVille($adresseDto->getVille());
    }

    public function transformeAdresseToAdresseDto(Adresse $adresse,AdresseDto $adresseDto):AdresseDto
    {
        return $adresseDto->setId($adresse->getId())
                        ->setNumRue($adresse->getNumRue())
                        ->setRue($adresse->getRue())
                        ->setCodePostal($adresse->getCodePostal())
                        ->setVille($adresse->getVille());
    }
}