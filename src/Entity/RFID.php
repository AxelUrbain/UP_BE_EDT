<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RFIDRepository")
 */
class RFID
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fonction", inversedBy="RFIDs")
     */
    private $fonction;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Professeur", mappedBy="RFID", cascade={"persist", "remove"})
     */
    private $professeur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\IdEtudiant", mappedBy="RFID", cascade={"persist", "remove"})
     */
    private $idEtudiant;

    public function __construct()
    {
        $this->fonction = new ArrayCollection();
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Fonction[]
     */
    public function getFonction(): Collection
    {
        return $this->fonction;
    }

    public function addFonction(Fonction $fonction): self
    {
        if (!$this->fonction->contains($fonction)) {
            $this->fonction[] = $fonction;
        }

        return $this;
    }

    public function removeFonction(Fonction $fonction): self
    {
        if ($this->fonction->contains($fonction)) {
            $this->fonction->removeElement($fonction);
        }

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        // set (or unset) the owning side of the relation if necessary
        $newRFID = null === $professeur ? null : $this;
        if ($professeur->getRFID() !== $newRFID) {
            $professeur->setRFID($newRFID);
        }

        return $this;
    }

    public function getIdEtudiant(): ?IdEtudiant
    {
        return $this->idEtudiant;
    }

    public function setIdEtudiant(?IdEtudiant $idEtudiant): self
    {
        $this->idEtudiant = $idEtudiant;

        // set (or unset) the owning side of the relation if necessary
        $newRFID = null === $idEtudiant ? null : $this;
        if ($idEtudiant->getRFID() !== $newRFID) {
            $idEtudiant->setRFID($newRFID);
        }

        return $this;
    }
}
