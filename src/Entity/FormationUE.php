<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationUERepository")
 */
class FormationUE
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation", inversedBy="formationUEs")
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UE", inversedBy="formationUEs")
     */
    private $ue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeFormation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUe(): ?UE
    {
        return $this->ue;
    }

    public function setUe(?UE $ue): self
    {
        $this->ue = $ue;

        return $this;
    }

    public function getAnneeFormation(): ?int
    {
        return $this->anneeFormation;
    }

    public function setAnneeFormation(int $anneeFormation): self
    {
        $this->anneeFormation = $anneeFormation;

        return $this;
    }
}
