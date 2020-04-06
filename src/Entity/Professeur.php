<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesseurRepository")
 */
class Professeur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Statut", inversedBy="professeurs")
     */
    private $statut;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RFID", inversedBy="professeur", cascade={"persist", "remove"})
     */
    private $RFID;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cours", mappedBy="professeur", cascade={"persist", "remove"})
     */
    private $cours;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialite", inversedBy="professeurs")
     */
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formation", mappedBy="professeurResponsable", cascade={"persist", "remove"})
     */
    private $formations;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getRFID(): ?RFID
    {
        return $this->RFID;
    }

    public function setRFID(?RFID $RFID): self
    {
        $this->RFID = $RFID;

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
            $cour->setProfesseur($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getProfesseur() === $this) {
                $cour->setProfesseur(null);
            }
        }

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
            $formation->setProfesseurResponsable($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            // set the owning side to null (unless already changed)
            if ($formation->getProfesseurResponsable() === $this) {
                $formation->setProfesseurResponsable(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getRFID()->getNom();
    }
}
