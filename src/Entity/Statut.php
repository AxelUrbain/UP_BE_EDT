<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatutRepository")
 */
class Statut
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
    private $nomStatut;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $serviceStatutaire;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $coefficient;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Professeur", mappedBy="statut")
     */
    private $professeurs;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStatut(): ?string
    {
        return $this->nomStatut;
    }

    public function setNomStatut(?string $nomStatut): self
    {
        $this->nomStatut = $nomStatut;

        return $this;
    }

    public function getServiceStatutaire(): ?float
    {
        return $this->serviceStatutaire;
    }

    public function setServiceStatutaire(?float $serviceStatutaire): self
    {
        $this->serviceStatutaire = $serviceStatutaire;

        return $this;
    }

    public function getCoefficient(): ?float
    {
        return $this->coefficient;
    }

    public function setCoefficient(?float $coefficient): self
    {
        $this->coefficient = $coefficient;

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
            $professeur->setStatut($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeurs->contains($professeur)) {
            $this->professeurs->removeElement($professeur);
            // set the owning side to null (unless already changed)
            if ($professeur->getStatut() === $this) {
                $professeur->setStatut(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getNomStatut();
    }
}
