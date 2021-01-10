<?php

namespace App\DTO;

use App\Entity\Adresse;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class PatientDto
{
    private $id;
    private $nom;
    private $prenom;
    private $dateNaissance;
    private $email;
    private $practicien;
    private $adresse;
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
     * Get the value of dateNaissance
     */
    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    /**
     * Set the value of dateNaissance
     *
     * @return  self
     */
    public function setDateNaissance(?string $dateNaissance): ?self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get the value of practicien
     */
    public function getPracticien(): ?collection
    {
        return $this->practicien;
    }

    /**
     * Set the value of practicien
     *
     * @return  self
     */
    public function setPracticien(?collection $practicien): ?self
    {
        $this->practicien = $practicien;

        return $this;
    }

    /**
     * Get the value of adresse
     */
    public function getAdresse(): ?int
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */
    public function setAdresse(?int $adresse): ?self
    {
        $this->adresse = $adresse;

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

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail(?string $email): ?self
    {
        $this->email = $email;

        return $this;
    }
}
