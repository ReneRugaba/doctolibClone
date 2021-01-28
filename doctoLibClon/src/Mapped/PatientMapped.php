<?php

namespace App\Mapped;

use App\DTO\PatientDto;
use App\Entity\Adresse;
use App\Entity\Patient;
use App\Security\User;
use DateTime;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PatientMapped
{
    private $patientDto;
    private $encodepassword;

    public function __construct(
        PatientDto $patientDto,
        UserPasswordEncoderInterface  $encodepassword
    ) {
        $this->patientDto = $patientDto;
        $this->encodepassword = $encodepassword;
    }
    public function transformPatientToPatientDto(Patient $patient): PatientDto
    {
        
        $patientDto = $this->patientDto->setId($patient->getId())->setNom($patient->getNom())
            ->setPrenom($patient->getPrenom())->setDateNaissance($patient->getDateNaissance()->format("d-m-Y"))
            ->setAdresse($patient->getAdresse())->setEmail($patient->getEmail());
            
        return $patientDto;
    }

    public function transformPatientDtoToPatient(Patient $patient, PatientDto $patientDto, Adresse $adresse): Patient
    {
        $patient->setNom($patientDto->getNom())->setPrenom($patientDto->getPrenom())
            ->setAdresse($adresse)->setDateNaissance(new DateTime($patientDto->getDateNaissance()))
            ->setEmail($patientDto->getEmail())->setPassword($this->encodepassword->encodePassword(new User, $patientDto->getPassword()));
        return $patient;
    }
}
