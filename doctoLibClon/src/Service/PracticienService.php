<?php

namespace App\Service;

use Doctrine\DBAL\Exception;
use App\Mapped\PracticienMapped;
use App\Repository\PracticienRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Exception\ServiceException;



class PracticienService
{
    private $practicien;
    private $pacticienMapped;
    private $manager;

    public function __construct(PracticienRepository $practicien, PracticienMapped $pacticienMapped, EntityManagerInterface $manager)
    {
        $this->practicien = $practicien;
        $this->pacticienMapped = $pacticienMapped;
        $this->manager = $manager;
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

    public function percist($practicien, $practicienDto)
    {
        try {
            $newPracticien = $this->pacticienMapped->transformPracticienDtoToPracticien($practicien, $practicienDto);
            $this->manager->persist($newPracticien);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

    public function removePracticien($id)
    {
        try {
            $this->manager->remove($id);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }
}
