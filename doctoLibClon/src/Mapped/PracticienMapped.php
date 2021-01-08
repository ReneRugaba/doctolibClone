<?php

namespace App\Mapped;

use App\DTO\PracticienDto;
use App\Entity\Practicien;
use App\Repository\AdresseRepository;
use App\Repository\SpecialiteRepository;

class PracticienMapped
{
    private $AdresseRepository;
    private $specialiterepository;

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
            ->setUsername($practien->getUsername())->setPassword($practien->getPassword());

        return $practicienDto;
    }

    // cette fonction transforme l'objets PractiuenDto en Practicien
    public function transformPracticienDtoToPracticien(Practicien $practicien, PracticienDto $practicienDto): Practicien
    {
        // ici je recupère deux objets des class Specialite et Adresse en passant par le repository
        $adresse = $this->AdresseRepository->find($practicienDto->getIdAdresse());
        $specialite = $this->specialiterepository->find($practicienDto->getSpecialite());

        // ici je crée un nouveau practicien
        $practicien->setId($practicienDto->getId())->setNom($practicienDto->getNom())
            ->setPrenom($practicienDto->getPrenom())->setAdresse($adresse)
            ->setSpecialite($specialite)->setEmail($practicienDto->getUsername())
            ->setPassword($practicienDto->getPassword());

        return $practicien; //je retourne ce practicien après création
    }
}
