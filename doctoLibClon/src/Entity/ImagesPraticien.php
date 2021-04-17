<?php

namespace App\Entity;

use App\Repository\ImagesPraticienRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesPraticienRepository::class)
 */
class ImagesPraticien
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity=Practicien::class, inversedBy="imagesPraticiens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $praticien;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getPraticien(): ?Practicien
    {
        return $this->praticien;
    }

    public function setPraticien(?Practicien $praticien): self
    {
        $this->praticien = $praticien;

        return $this;
    }
}
