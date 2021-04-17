<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\schema()
 */
class ImagesPraticienDto{

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
    private $nameFile;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $name;

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
    public function setId(?int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nameFile
     */ 
    public function getNameFile():?string
    {
        return $this->nameFile;
    }

    /**
     * Set the value of nameFile
     *
     * @return  self
     */ 
    public function setNameFile(?string $nameFile):self
    {
        $this->nameFile = $nameFile;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName():?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(?string $name):self
    {
        $this->name = $name;

        return $this;
    }
}