<?php

namespace App\Mapped;

use App\DTO\PatientDto;
use App\Entity\Adresse;
use App\Entity\Patient;
use DateTime;

class PatientMapped
{
    private $patientDto;

    public function __construct(PatientDto $patientDto)
    {
        $this->patientDto = $patientDto;
    }
    public function transformPatientToPatientDto(Patient $patient): PatientDto
    {
        $patientDto = $this->patientDto->setId($patient->getId())->setNom($patient->getNom())
            ->setPrenom($patient->getPrenom())->setDateNaissance($patient->getDateNaissance()->format("d-m-Y"))
            ->setPracticien($patient->getPracticien())->setAdresse($patient->getAdresse()->getId())->setEmail($patient->getEmail());
        return $patientDto;
    }

    public function transformPatientDtoToPatient(Patient $patient, PatientDto $patientDto, Adresse $adresse): Patient
    {
        $patient->setNom($patientDto->getNom())->setPrenom($patientDto->getPrenom())
            ->setAdresse($adresse)->setDateNaissance(new DateTime($patientDto->getDateNaissance()))
            ->setEmail($patientDto->getEmail())->setPassword($patientDto->getPassword());
        return $patient;
    }
}
