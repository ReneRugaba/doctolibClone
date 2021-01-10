<?php

namespace App\Service;

use App\DTO\PracticienDto;
use App\Entity\Practicien;
use Doctrine\DBAL\Exception;
use App\Mapped\PracticienMapped;
use App\Repository\AdresseRepository;
use App\Repository\PracticienRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Exception\ServiceException;



class PracticienService
{
    private $practicien;
    private $pacticienMapped;
    private $manager;
    private $adresseRepository;
    private $specialiterepository;

    public function __construct(
        PracticienRepository $practicien,
        PracticienMapped $pacticienMapped,
        EntityManagerInterface $manager,
        AdresseRepository $adresseRepository,
        SpecialiteRepository $specialiterepository
    ) {
        $this->practicien = $practicien;
        $this->pacticienMapped = $pacticienMapped;
        $this->manager = $manager;
        $this->adresseRepository = $adresseRepository;
        $this->specialiterepository = $specialiterepository;
    }

    public function searchAll()
    {
        try {
            $practiciens = $this->practicien->findAll();
            $practicienDtos = [];
            foreach ($practiciens as  $value) {
                $practicienDtos[] = $this->pacticienMapped->transformPracticienToPracticienDto($value);
            }
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
        return $practicienDtos;
    }

    // methode pour créer ou modifier un practicien
    public function percist(Practicien $practicien, PracticienDto $practicienDto)
    {
        // ici je recupère deux objets des class Specialite et Adresse en passant par le repository
        $adresadresse = $this->adresseRepository->find($practicienDto->getIdAdresse());
        $specialite = $this->specialiterepository->find($practicienDto->getSpecialite());
        try { //ici je passe à la methode transformPracticienDtoToPracticien de ma class PracticienMapped les arguments ci-dessus,
            //pour recuperer une instance de Practien $newPracticien
            $newPracticien = $this->pacticienMapped->transformPracticienDtoToPracticien($practicien, $practicienDto, $adresadresse, $specialite);
            //ici je persist et je flush mon Practicien dans ma base de donnée
            $this->manager->persist($newPracticien);
            $this->manager->flush();
        } catch (Exception $e) { // dans le cas ou l'opération se passe mal, je throw une exception vers ma couche controller
            throw new ServiceException($e->getMessage());
        }
    }

    // methode pour suprimer un Practicien
    public function removePracticien(Practicien $practicien) //ici je récupère le practicien à remove
    {
        try { //ici je passe mon practicien à la methode de mon entityManager qui va se charger de le remove et de le flush
            $this->manager->remove($practicien);
            $this->manager->flush();
        } catch (Exception $e) { //dans le cas ou une erreur survient, je le throw à ma couche controlleur
            throw new ServiceException($e->getMessage());
        }
    }
}
