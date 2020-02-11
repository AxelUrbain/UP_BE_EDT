<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FonctionRepository")
 */
class Fonction
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
    private $nomFonction;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RFID", mappedBy="fonction")
     */
    private $RFIDs;

    public function __construct()
    {
        $this->RFIDs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFonction(): ?string
    {
        return $this->nomFonction;
    }

    public function setNomFonction(?string $nomFonction): self
    {
        $this->nomFonction = $nomFonction;

        return $this;
    }

    /**
     * @return Collection|RFID[]
     */
    public function getRFIDs(): Collection
    {
        return $this->RFIDs;
    }

    public function addRFID(RFID $rFID): self
    {
        if (!$this->RFIDs->contains($rFID)) {
            $this->RFIDs[] = $rFID;
            $rFID->addFonction($this);
        }

        return $this;
    }

    public function removeRFID(RFID $rFID): self
    {
        if ($this->RFIDs->contains($rFID)) {
            $this->RFIDs->removeElement($rFID);
            $rFID->removeFonction($this);
        }

        return $this;
    }
}
