<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromotionRepository")
 */
class Promotion
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
    private $anneeFormation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\IdEtudiant", inversedBy="promotions")
     */
    private $idEtudiant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation", inversedBy="promotions")
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annee", inversedBy="promotions")
     */
    private $annee;

    public function __construct()
    {
        $this->idEtudiant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneeFormation(): ?int
    {
        return $this->anneeFormation;
    }

    public function setAnneeFormation(?int $anneeFormation): self
    {
        $this->anneeFormation = $anneeFormation;

        return $this;
    }

    /**
     * @return Collection|IdEtudiant[]
     */
    public function getIdEtudiant(): Collection
    {
        return $this->idEtudiant;
    }

    public function addIdEtudiant(IdEtudiant $idEtudiant): self
    {
        if (!$this->idEtudiant->contains($idEtudiant)) {
            $this->idEtudiant[] = $idEtudiant;
        }

        return $this;
    }

    public function removeIdEtudiant(IdEtudiant $idEtudiant): self
    {
        if ($this->idEtudiant->contains($idEtudiant)) {
            $this->idEtudiant->removeElement($idEtudiant);
        }

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): self
    {
        $this->annee = $annee;

        return $this;
    }
}
