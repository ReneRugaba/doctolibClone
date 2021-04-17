<?php

namespace App\Service;

use App\DTO\ConsultationDto;
use App\DTO\PatientDto;
use App\Entity\Patient;
use App\Entity\Consultation;
use App\Entity\Images;
use App\Mapped\AdresseMapped;
use App\Mapped\ConsultationMapped;
use App\Mapped\PatientMapped;
use App\Mapped\PracticienMapped;
use App\Repository\AdresseRepository;
use App\Repository\PatientRepository;
use App\Repository\PracticienRepository;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Exception\ServiceException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class PatientService
{
    private $patientRepository;
    private $patientMapped;
    private $manager;
    private $adresseRepository;
    private $consultationMapped;
    private $practicienRepository;
    private $adresseMapped;

    public function __construct(
        PatientRepository $patientRepository,
        PatientMapped $patientMapped,
        EntityManagerInterface $manager,
        AdresseRepository $adresseRepository,
        ConsultationMapped $consultationMapped,
        PracticienRepository $practicienRepository,
        PracticienMapped $practicienMapped,
        AdresseMapped $adresseMapped
    ) {
        $this->patientRepository = $patientRepository; //ici je factorise l'instanciation d'objet de patientRepository et la rend disponible dans toutes mes methodes
        $this->adresseRepository = $adresseRepository;
        $this->patientMapped = $patientMapped; //ici je factorise l'instanciation d'objet de patientMapped et la rend disponible dans toutes mes methodes
        $this->manager = $manager; //ici je factorise l'instanciation d'objet de EntityManagerInterface et la rend disponible dans toutes mes methodes
        $this->consultationMapped = $consultationMapped;
        $this->practicienRepository = $practicienRepository;
        $this->practicienMapped=$practicienMapped;
        $this->adresseMapped=$adresseMapped;
    }


    public function findCurrentUser($username){
        try {
            $userCurrent=$this->patientRepository->findBy(["email"=>$username]);
            $adresse=$this->adresseRepository->findBy(["id"=>$userCurrent[0]->getAdresse()]); 
            $patientDto= $this->patientMapped->transformPatientToPatientDto($userCurrent[0],$adresse[0]);
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
        return $patientDto;
    }

    public function searchPatient(array $array) //cette methode me permet de chercher tous les patient de ma bdd
    {
        try { //jerecupère les patients present dans ma bdd dans un $patien
            
            $patient = $this->patientRepository->findOneBy($array);
            // dd($patient);
        } catch (Exception $e) { //je 
            throw new ServiceException($e->getMessage());
        }
        
        $patientDto = $this->patientMapped->transformPatientToPatientDto($patient);
        return $patientDto; //je retourne le tableau de mes patientDto
    }

    public function persistPatient(Patient $patient,PatientDto $patientDto):PatientDto //cette methode me permet de créer et de modifier mon Patient
    {
        
        try { 
           
                $adresseExist = $this->adresseRepository->findby(["numRue"=>$patientDto->getAdresse()->getNumRue(),
                                                                "rue"=>$patientDto->getAdresse()->getRue(),
                                                                "codePostal"=>$patientDto->getAdresse()->getCodePostal()]);
             
                if (!$adresseExist) {
                    $newAdresse=$this->adresseMapped->transformeAdresseDtoToAdresse($patientDto->getAdresse());
                    $this->manager->persist($newAdresse);
                    $this->manager->flush();
                    $adresse=$this->adresseRepository->findby(["numRue"=>$newAdresse->getNumRue(),
                                                                "rue"=>$newAdresse->getRue(),
                                                                "codePostal"=>$newAdresse->getCodePostal()])[0];
                }else{
                    $adresse = $adresseExist[0];
                }
                
            
            
            //j'utilise la methode transformPatientDtoToPatient à qui je passe en argu mes trois objets pour récupérer un patient modifié ou créé
            $newPatient = $this->patientMapped->transformPatientDtoToPatient($patient, $patientDto, $adresse);
            
            $this->manager->persist($newPatient); // je le persist
            $this->manager->flush(); // j'execute pour persiter dans la bdd
            $newadress= $this->adresseRepository->findby(["id"=>$adresse->getId()]);
        } catch (Exception $e) { // dans le cas ou une exception est émise  je la throw vers mon controller ici
            throw new ServiceException($e->getMessage());
        }
        return $this->patientMapped->transformPatientToPatientDto($newPatient, $newadress[0]);
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
            $patient = $this->patientRepository->find($consultationDto->getPatient()->getId());
            $practicien = $this->practicienRepository->find($consultationDto->getPracticien()->getId());
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
                $patientDto=$this->patientMapped->transformPatientToPatientDto($value->getPatient(),$value->getPatient()->getAdresse());
                $practicienDto=$this->practicienMapped->transformPracticienToPracticienDto($value->getPracticien());
                
                $consultationArrayDto[] = $this->consultationMapped->transformeConsultationToConsultationDto(new ConsultationDto, $value,$patientDto,$practicienDto);
            }
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
        return $consultationArrayDto;
    }

    public function setImagePatientTorepository(File $file, Patient $patient,string $destination){
        $name=md5(uniqid());
        $nameFile=$name.".".$file->guessExtension();
        $newImage=(new Images())->setName($name)->setFileName($nameFile);

        try {
            $this->manager->persist($patient->addImage($newImage));
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
        $file->move(
            $destination,
            $nameFile
        );
    }
}
