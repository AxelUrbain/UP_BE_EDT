<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UERepository")
 */
class UE
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
    private $couleur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $volumeHoraire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomUE;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialite", inversedBy="UEs")
     */
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cours", mappedBy="UE")
     */
    private $cours;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Etudiant", mappedBy="UE")
     */
    private $etudiants;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", mappedBy="UE")
     */
    private $formations;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getVolumeHoraire(): ?float
    {
        return $this->volumeHoraire;
    }

    public function setVolumeHoraire(?float $volumeHoraire): self
    {
        $this->volumeHoraire = $volumeHoraire;

        return $this;
    }

    public function getNomUE(): ?string
    {
        return $this->nomUE;
    }

    public function setNomUE(?string $nomUE): self
    {
        $this->nomUE = $nomUE;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->setUE($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getUE() === $this) {
                $cour->setUE(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->addUE($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            $etudiant->removeUE($this);
        }

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->addUE($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            $formation->removeUE($this);
        }

        return $this;
    }
}
