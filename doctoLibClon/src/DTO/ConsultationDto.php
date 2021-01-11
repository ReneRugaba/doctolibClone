<?php

namespace App\DTO;

class ConsultationDto
{
    private $id;
    private $dateRdv;
    private $patient;
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
    public function setId(?int $id)
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
    public function getPatient(): ?int
    {
        return $this->patient;
    }

    /**
     * Set the value of patient
     *
     * @return  self
     */
    public function setPatient(?int $patient): ?self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get the value of practicien
     */
    public function getPracticien(): ?int
    {
        return $this->practicien;
    }

    /**
     * Set the value of practicien
     *
     * @return  self
     */
    public function setPracticien(?int $practicien): ?self
    {
        $this->practicien = $practicien;

        return $this;
    }
}
