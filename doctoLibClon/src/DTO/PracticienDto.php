<?php

namespace App\DTO;

use App\Entity\Adresse;
use App\Entity\Consultation;
use App\Entity\Specialite;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class PracticienDto
{
    private $id;
    private $nom;
    private $prenom;
    private $patient;
    private $idAdresse;
    private $consultation;
    private $specialite;
    private $username;
    private $password;


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
    public function setId(?int $id): ?self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom(?string $nom): ?self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */
    public function setPrenom(?string $prenom): ?self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of patient
     */
    public function getPatient(): ?Collection
    {
        return $this->patient;
    }

    /**
     * Set the value of patient
     *
     * @return  self
     */
    public function setPatient(?Collection $patient): ?self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get the value of idAdresse
     */
    public function getIdAdresse(): ?int
    {
        return $this->idAdresse;
    }

    /**
     * Set the value of idAdresse
     *
     * @return  self
     */
    public function setIdAdresse(?Int $idAdresse): ?self
    {
        $this->idAdresse = $idAdresse;

        return $this;
    }

    /**
     * Get the value of consultation
     */
    public function getConsultation(): ?Collection
    {
        return $this->consultation;
    }

    /**
     * Set the value of consultation
     *
     * @return  self
     */
    public function setConsultation(?Collection $consultation): ?self
    {
        $this->consultation = $consultation;

        return $this;
    }

    /**
     * Get the value of specialite
     */
    public function getSpecialite(): ?int
    {
        return $this->specialite;
    }

    /**
     * Set the value of specialite
     *
     * @return  self
     */
    public function setSpecialite(?int $specialite): ?self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername(?string $username): ?self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword(?string $password): ?self
    {
        $this->password = $password;

        return $this;
    }
}
