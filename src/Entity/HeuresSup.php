<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HeuresSupRepository")
 */
class HeuresSup
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
    private $anneePaye;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tauxHoraire;

    public function __construct()
    {
        $date = new \DateTime();
        $this->setAnneePaye((int) $date->format('Y'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneePaye(): ?int
    {
        return $this->anneePaye;
    }

    public function setAnneePaye(?int $anneePaye): self
    {
        $this->anneePaye = $anneePaye;

        return $this;
    }

    public function getTauxHoraire(): ?float
    {
        return $this->tauxHoraire;
    }

    public function setTauxHoraire(?float $tauxHoraire): self
    {
        $this->tauxHoraire = $tauxHoraire;

        return $this;
    }
}
