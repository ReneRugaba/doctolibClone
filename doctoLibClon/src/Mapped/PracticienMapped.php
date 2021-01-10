<?php

namespace App\Mapped;

use App\DTO\PracticienDto;
use App\Entity\Adresse;
use App\Entity\Practicien;
use App\Entity\Specialite;
use App\Repository\AdresseRepository;
use App\Repository\SpecialiteRepository;

class PracticienMapped
{

    public function __construct(AdresseRepository $AdresseRepository, SpecialiteRepository $specialiterepository)
    {
        $this->AdresseRepository = $AdresseRepository;
        $this->specialiterepository = $specialiterepository;
    }

    // cette fonction transforme l'objet Practicien en PractiuenDto
    public function transformPracticienToPracticienDto(Practicien $practien): PracticienDto
    {
        $practicienDto = (new PracticienDto())->setId($practien->getId())->setNom($practien->getNom())
            ->setPrenom($practien->getPrenom())->setPatient($practien->getPatient())->setIdAdresse($practien->getAdresse()->getId())
            ->setConsultation($practien->getConsultation())->setSpecialite($practien->getSpecialite()->getId())
            ->setUsername($practien->getUsername());

        return $practicienDto;
    }

    // cette fonction transforme l'objets PractiuenDto en Practicien
    public function transformPracticienDtoToPracticien(
        Practicien $practicien,
        PracticienDto $practicienDto,
        Adresse $adresse = null,
        Specialite $specialite = null
    ): Practicien {

        // ici je crée un nouveau practicien
        $practicien->setId($practicienDto->getId())->setNom($practicienDto->getNom())
            ->setPrenom($practicienDto->getPrenom())->setAdresse($adresse)
            ->setSpecialite($specialite)->setEmail($practicienDto->getUsername())
            ->setPassword($practicienDto->getPassword());

        return $practicien; //je retourne ce practicien après création
    }
}
