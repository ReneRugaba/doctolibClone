<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\schema()
 */
class AdresseDto{

    /**
     * @OA\Property(type="integer")
     *
     * @var int|null
     */
    private $id;

    /**
     * @OA\Property(type="integer")
     *
     * @var int|null
     */
    private $numRue;

    /**
     * @OA\Property(type="string")
     *
     * @var string|null
     */
    private $rue;

    /**
     * @OA\Property(type="integer")
     *
     * @var int|null
     */
    private $codePostal;

    /**
     * @OA\Property(type="string")
     *
     * @var string|null
     */
    private $ville;

    /**
     * Get the value of id
     */ 
    public function getId():?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of numRue
     */ 
    public function getNumRue():?int
    {
        return $this->numRue;
    }

    /**
     * Set the value of numRue
     *
     * @return  self
     */ 
    public function setNumRue(?int $numRue): self
    {
        $this->numRue = $numRue;

        return $this;
    }

    /**
     * Get the value of rue
     */ 
    public function getRue():?string
    {
        return $this->rue;
    }

    /**
     * Set the value of rue
     *
     * @return  self
     */ 
    public function setRue(?string $rue):self
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get the value of codePostal
     */ 
    public function getCodePostal():?int
    {
        return $this->codePostal;
    }

    /**
     * Set the value of codePostal
     *
     * @return  self
     */ 
    public function setCodePostal(?int $codePostal):self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get the value of ville
     */ 
    public function getVille():?string
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */ 
    public function setVille(?string $ville):self
    {
        $this->ville = $ville;

        return $this;
    }
}