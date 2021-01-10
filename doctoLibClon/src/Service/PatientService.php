<?php

namespace App\Service;


use App\Entity\Patient;
use App\Mapped\PatientMapped;
use App\Repository\AdresseRepository;
use App\Repository\PatientRepository;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Exception\ServiceException;

class PatientService
{
    private $patientRepository;
    private $patientMapped;
    private $manager;
    private $adresseRepository;

    public function __construct(
        PatientRepository $patientRepository,
        PatientMapped $patientMapped,
        EntityManagerInterface $manager,
        AdresseRepository $adresseRepository
    ) {
        $this->patientRepository = $patientRepository; //ici je factorise l'instanciation d'objet de patientRepository et la rend disponible dans toutes mes methodes
        $this->adresseRepository = $adresseRepository;
        $this->patientMapped = $patientMapped; //ici je factorise l'instanciation d'objet de patientMapped et la rend disponible dans toutes mes methodes
        $this->manager = $manager; //ici je factorise l'instanciation d'objet de EntityManagerInterface et la rend disponible dans toutes mes methodes
    }


    public function searchAll() //cette methode me permet de chercher tous les patient de ma bdd
    {
        try { //jerecupère les patients present dans ma bdd dans un tableau $patiens
            $patients = $this->patientRepository->findAll();
            $patientsDtos = []; //j'initialise un tableau vide pour contenir mes patientDto
        } catch (Exception $e) { //je 
            throw new ServiceException($e->getMessage());
        }
        foreach ($patients as  $value) { //je fais un foreach pour transformet mes patient en patientDto
            $patientsDtos[] = $this->patientMapped->transformPatientToPatientDto($value);
        }
        return $patientsDtos; //je retourne le tableau de mes patientDto
    }

    public function persist($patient, $patientDto) //cette methode me permet de créer et de modifier mon Patient
    {

        try {
            $adresse = $this->adresseRepository->find($patientDto->getAdresse());
            $newPatient = $this->patientMapped->transformPatientDtoToPatient($patient, $patientDto, $adresse);
            $this->manager->persist($newPatient);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

    public function removePatient(Patient $patient)
    {
        try {
            $this->manager->remove($patient);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }
}
