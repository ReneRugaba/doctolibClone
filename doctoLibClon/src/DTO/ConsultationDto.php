<?php

namespace App\DTO;


use OpenApi\Annotations as OA;

/**
 * @OA\schema()
 */
class ConsultationDto
{
    /**
     * @OA\Property(type="integer")
     *
     * @var integer|null
     */
    private $id;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $dateRdv;

    /**
     * @OA\Property(type="PatientDto")
     *
     * @var PatientDto|null
     */
    private $patient;

    /**
     * @OA\Property(type="PracticienDto")
     *
     * @var PracticienDto|null
     */
    private $practicien;

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(?int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of dateRdv
     */
    public function getDateRdv(): ?string
    {
        return $this->dateRdv;
    }

    /**
     * Set the value of dateRdv
     *
     * @return  self
     */
    public function setDateRdv(?string $dateRdv): ?self
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    /**
     * Get the value of patient
     */
    public function getPatient(): ?PatientDto
    {
        return $this->patient;
    }

    /**
     * Set the value of patient
     *
     * @return  self
     */
    public function setPatient(?PatientDto $patient): ?self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get the value of practicien
     */
    public function getPracticien(): ?PracticienDto
    {
        return $this->practicien;
    }

    /**
     * Set the value of practicien
     *
     * @return  self
     */
    public function setPracticien(?PracticienDto $practicien): ?self
    {
        $this->practicien = $practicien;

        return $this;
    }
}
