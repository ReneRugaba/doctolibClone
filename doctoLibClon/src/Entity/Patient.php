<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatientRepository;
use App\Security\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 * 
 */
class Patient extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="le nom ne peux être vide!")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="le prenom ne peux être vide!")
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("object")
     */
    private $dateNaissance;

    /**
     * @ORM\ManyToMany(targetEntity=Practicien::class, inversedBy="Patient")
     */
    private $practicien;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class)
     */
    private $adresse;



    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="patient",cascade={"persist"})
     * 
     */
    private $consultations;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="patient", cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->practicien = new ArrayCollection();
        $this->consultations = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection|Practicien[]
     */
    public function getPracticien(): Collection
    {
        return $this->practicien;
    }

    public function addPracticien(Practicien $practicien): self
    {
        if (!$this->practicien->contains($practicien)) {
            $this->practicien[] = $practicien;
        }

        return $this;
    }

    public function removePracticien(Practicien $practicien): self
    {
        $this->practicien->removeElement($practicien);

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * 
     * @return Collection|Consultation[]
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPatient($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPatient() === $this) {
                $image->setPatient(null);
            }
        }

        return $this;
    }
}
