<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class Cours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $creneau;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isExam;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValide;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UE", inversedBy="cours")
     * @Assert\NotBlank(message="L'UE est obligatoire")
     * @Assert\Valid()
     *
     */
    private $UE;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Salle", inversedBy="cours")
     * @Assert\NotNull(message="Aucune salle n'est disponible")
     */
    private $salle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professeur", inversedBy="cours")
     * @Assert\NotNull(message="Aucun professeur n'est disponible")
     */
    private $professeur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", mappedBy="cours")
     */
    private $formations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Etudiant", mappedBy="cours")
     */
    private $etudiants;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreneau(): ?int
    {
        return $this->creneau;
    }

    public function setCreneau(?int $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getIsExam(): ?bool
    {
        return $this->isExam;
    }

    public function setIsExam(?bool $isExam): self
    {
        $this->isExam = $isExam;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(?\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getIsValide(): ?bool
    {
        return $this->isValide;
    }

    public function setIsValide(?bool $isValide): self
    {
        $this->isValide = $isValide;

        return $this;
    }

    public function getUE(): ?UE
    {
        return $this->UE;
    }

    public function setUE(?UE $UE): self
    {
        $this->UE = $UE;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

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
            $formation->addCour($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            $formation->removeCour($this);
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
            $etudiant->addCour($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            $etudiant->removeCour($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getUE()->getNomUE();
    }
}
