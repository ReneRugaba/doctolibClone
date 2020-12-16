<?php

namespace App\Entity;

use App\Repository\PracticienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PracticienRepository::class)
 */
class Practicien
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
     * @ORM\Column(type="string", length=100)
     * @Assert\Regex(
     * pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     * message="Votre email n'est pas valide!"
     * )
     */
    private $email;

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
     * @ORM\OneToOne(targetEntity=Specialite::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialite;

    public function __construct()
    {
        $this->Patient = new ArrayCollection();
        $this->consultation = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }
}
