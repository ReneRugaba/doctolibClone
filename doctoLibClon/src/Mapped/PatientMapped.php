<?php

namespace App\Mapped;

use App\DTO\AdresseDto;
use App\DTO\ImageDto;
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
    private $adresseMapped;

    public function __construct(
        PatientDto $patientDto,
        UserPasswordEncoderInterface  $encodepassword,
        AdresseMapped $adresseMapped
    ) {
        $this->patientDto = $patientDto;
        $this->encodepassword = $encodepassword;
        $this->adresseMapped=$adresseMapped;
    }
    public function transformPatientToPatientDto(Patient $patient,$adresse=null): PatientDto
    {
        if($adresse){
            $adresseDto= $this->adresseMapped->transformeAdresseToAdresseDto($adresse,new AdresseDto);
        }
        $arrayImages=[];
        
        foreach ($patient->getImages() as  $value) {
            $arrayImages[]=(new ImageDto())->setNameFile("/uploads/".$value->getFileName())
                            ->setId($value->getId())->setName($value->getName());
        }
        
        $patientDto = $this->patientDto->setId($patient->getId())->setNom($patient->getNom())
            ->setPrenom($patient->getPrenom())->setDateNaissance($patient->getDateNaissance()->format("d-m-Y"))
            ->setAdresse($adresseDto)->setEmail($patient->getEmail())->setImage($arrayImages);
            
        return $patientDto;
    }

    public function transformPatientDtoToPatient(Patient $patient, PatientDto $patientDto, Adresse $adresse): Patient
    {
        
        $patient->setNom($patientDto->getNom())->setPrenom($patientDto->getPrenom())
            ->setAdresse($adresse)->setDateNaissance(new DateTime($patientDto->getDateNaissance()))
            ->setEmail($patientDto->getEmail())
            ->setPassword($this->encodepassword->encodePassword(new User, $patientDto->getPassword()));
        return $patient;
    }
}
