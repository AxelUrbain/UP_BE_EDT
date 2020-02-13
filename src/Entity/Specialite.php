<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialiteRepository")
 */
class Specialite
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
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UE", mappedBy="specialite")
     */
    private $UEs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Professeur", mappedBy="specialite", cascade={"persist", "remove"})
     */
    private $professeurs;

    public function __construct()
    {
        $this->UEs = new ArrayCollection();
        $this->professeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection|UE[]
     */
    public function getUEs(): Collection
    {
        return $this->UEs;
    }

    public function addUE(UE $uE): self
    {
        if (!$this->UEs->contains($uE)) {
            $this->UEs[] = $uE;
            $uE->setSpecialite($this);
        }

        return $this;
    }

    public function removeUE(UE $uE): self
    {
        if ($this->UEs->contains($uE)) {
            $this->UEs->removeElement($uE);
            // set the owning side to null (unless already changed)
            if ($uE->getSpecialite() === $this) {
                $uE->setSpecialite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Professeur[]
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs[] = $professeur;
            $professeur->setSpecialite($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeurs->contains($professeur)) {
            $this->professeurs->removeElement($professeur);
            // set the owning side to null (unless already changed)
            if ($professeur->getSpecialite() === $this) {
                $professeur->setSpecialite(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
<<<<<<< HEAD
        // TODO: Implement __toString() method.
        return $this->getSpecialite();
    }
=======
        return $this->getSpecialite();
    }


>>>>>>> testBDD
}
