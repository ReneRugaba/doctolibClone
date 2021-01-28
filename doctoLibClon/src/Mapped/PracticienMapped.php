<?php

namespace App\Mapped;

use App\Entity\Adresse;
use App\DTO\PracticienDto;
use App\Entity\Practicien;
use App\Entity\Specialite;
use App\DTO\ConsultationDto;
use App\Mapped\PatientMapped;
use App\Repository\AdresseRepository;
use App\Repository\SpecialiteRepository;

class PracticienMapped
{
    private $consultationMapped;
    private $patientMapped;


    public function __construct(
        ConsultationMapped $consultationMapped,
        PatientMapped $patientMapped
    ) {

        $this->consultationMapped = $consultationMapped;
        $this->patientMapped = $patientMapped;
    }

    // cette fonction transforme l'objet Practicien en PractiuenDto
    public function transformPracticienToPracticienDto(Practicien $practien): PracticienDto
    {

        $consult = [];
        foreach ($practien->getConsultation() as $value) {
            $consult[] = $this->consultationMapped->transformeConsultationToConsultationDto(new ConsultationDto, $value);
        }
        $patientDtoArray = [];
        foreach ($practien->getPatient() as $value) {
            $patientDtoArray[] = $this->patientMapped->transformPatientToPatientDto($value);
        }

        $practicienDto = (new PracticienDto())->setId($practien->getId())->setNom($practien->getNom())
            ->setPrenom($practien->getPrenom())->setPatient($patientDtoArray)->setIdAdresse($practien->getAdresse()->getId())
            ->setConsultation($consult)->setSpecialite($practien->getSpecialite()->getId())
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
