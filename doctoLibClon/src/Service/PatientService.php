<?php

namespace App\Service;

use App\DTO\ConsultationDto;
use App\Entity\Patient;
use App\Entity\Consultation;
use App\Mapped\ConsultationMapped;
use App\Mapped\PatientMapped;
use App\Repository\AdresseRepository;
use App\Repository\PatientRepository;
use App\Repository\PracticienRepository;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Exception\ServiceException;
use Symfony\Component\HttpFoundation\Request;

class PatientService
{
    private $patientRepository;
    private $patientMapped;
    private $manager;
    private $adresseRepository;
    private $consultationMapped;
    private $practicienRepository;


    public function __construct(
        PatientRepository $patientRepository,
        PatientMapped $patientMapped,
        EntityManagerInterface $manager,
        AdresseRepository $adresseRepository,
        ConsultationMapped $consultationMapped,
        PracticienRepository $practicienRepository
    ) {
        $this->patientRepository = $patientRepository; //ici je factorise l'instanciation d'objet de patientRepository et la rend disponible dans toutes mes methodes
        $this->adresseRepository = $adresseRepository;
        $this->patientMapped = $patientMapped; //ici je factorise l'instanciation d'objet de patientMapped et la rend disponible dans toutes mes methodes
        $this->manager = $manager; //ici je factorise l'instanciation d'objet de EntityManagerInterface et la rend disponible dans toutes mes methodes
        $this->consultationMapped = $consultationMapped;
        $this->practicienRepository = $practicienRepository;
    }


    public function searchPatient(array $array) //cette methode me permet de chercher tous les patient de ma bdd
    {
        try { //jerecupère les patients present dans ma bdd dans un $patien
            $patient = $this->patientRepository->findOneBy($array);
        } catch (Exception $e) { //je 
            throw new ServiceException($e->getMessage());
        }
        
        $patientDto = $this->patientMapped->transformPatientToPatientDto($patient);
        return $patientDto; //je retourne le tableau de mes patientDto
    }

    public function persist($patient, $patientDto) //cette methode me permet de créer et de modifier mon Patient
    {

        try { //jerecupère l'objet adresse present dans ma bdd grâce para en argu de find $patientDto->getAdresse()
            $adresse = $this->adresseRepository->find($patientDto->getAdresse());
            //j'utilise la methode transformPatientDtoToPatient à qui je passe en argu mes trois objets pour récupérer un patient modifié ou créé
            $newPatient = $this->patientMapped->transformPatientDtoToPatient($patient, $patientDto, $adresse);
            $this->manager->persist($newPatient); // je le persist
            $this->manager->flush(); // j'execute pour persiter dans la bdd
        } catch (Exception $e) { // dans le cas ou une exception est émise  je la throw vers mon controller ici
            throw new ServiceException($e->getMessage());
        }
    }

    public function removePatient(Patient $patient) // cette methode suprime le patient en para de celle-ci
    {
        try {
            $this->manager->remove($patient); //je remove le patient et j'execute la suppression grace au flush
            $this->manager->flush();
        } catch (Exception $e) { // dans le cas ou une exception est émise  je la throw vers mon controller ici
            throw new ServiceException($e->getMessage());
        }
    }


    public function addRdvConsult(ConsultationDto $consultationDto)
    {
        try {
            $patient = $this->patientRepository->find($consultationDto->getPatient());
            $practicien = $this->practicienRepository->find($consultationDto->getPracticien());
            $newConsultation = $this->consultationMapped->transformeConsultationDtoToConsultation(new Consultation, $consultationDto, $patient, $practicien);
            $patient->addConsultation($newConsultation);
            $this->manager->persist($patient);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

    public function removeConsultation(Consultation $consultation)
    {
        try {
            $this->manager->remove($consultation);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

    public function showConsultation(Patient $patient)
    {
        try {
            $consultationArray = $patient->getConsultations();
            $consultationArrayDto = [];
            foreach ($consultationArray as $value) {
                $consultationArrayDto[] = $this->consultationMapped->transformeConsultationToConsultationDto(new ConsultationDto, $value);
            }
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
        return $consultationArrayDto;
    }
}
