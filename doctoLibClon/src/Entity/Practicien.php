<?php

namespace App\Entity;

use App\Repository\PracticienRepository;
use App\Security\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PracticienRepository::class)
 */
class Practicien extends User
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
     * @ORM\ManyToMany(targetEntity=Patient::class, mappedBy="practicien")
     */
    private $Patient;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="practicien")
     */
    private $consultation;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity=ImagesPraticien::class, mappedBy="praticien", orphanRemoval=true)
     */
    private $imagesPraticiens;

    public function __construct()
    {
        $this->Patient = new ArrayCollection();
        $this->consultation = new ArrayCollection();
        $this->imagesPraticiens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): ?self
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

    /**
     * @return Collection|Patient[]
     */
    public function getPatient(): Collection
    {
        return $this->Patient;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->Patient->contains($patient)) {
            $this->Patient[] = $patient;
            $patient->addPracticien($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->Patient->removeElement($patient)) {
            $patient->removePracticien($this);
        }

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
     * @return Collection|Consultation[]
     */
    public function getConsultation(): Collection
    {
        return $this->consultation;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultation->contains($consultation)) {
            $this->consultation[] = $consultation;
            $consultation->setPracticien($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultation->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPracticien() === $this) {
                $consultation->setPracticien(null);
            }
        }

        return $this;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
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
     * @return Collection|ImagesPraticien[]
     */
    public function getImagesPraticiens(): Collection
    {
        return $this->imagesPraticiens;
    }

    public function addImagesPraticien(ImagesPraticien $imagesPraticien): self
    {
        if (!$this->imagesPraticiens->contains($imagesPraticien)) {
            $this->imagesPraticiens[] = $imagesPraticien;
            $imagesPraticien->setPraticien($this);
        }

        return $this;
    }

    public function removeImagesPraticien(ImagesPraticien $imagesPraticien): self
    {
        if ($this->imagesPraticiens->removeElement($imagesPraticien)) {
            // set the owning side to null (unless already changed)
            if ($imagesPraticien->getPraticien() === $this) {
                $imagesPraticien->setPraticien(null);
            }
        }

        return $this;
    }
}
