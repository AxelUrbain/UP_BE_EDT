<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RFID", inversedBy="etudiant", cascade={"persist", "remove"})
     */
    private $RFID;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UE", inversedBy="etudiants")
     */
    private $UE;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", inversedBy="etudiants")
     */
    private $cours;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion", inversedBy="etudiants")
     */
    private $promotion;

    public function __construct()
    {
        $this->UE = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|UE[]
     */
    public function getUE(): Collection
    {
        return $this->UE;
    }

    public function addUE(UE $uE): self
    {
        if (!$this->UE->contains($uE)) {
            $this->UE[] = $uE;
        }

        return $this;
    }

    public function removeUE(UE $uE): self
    {
        if ($this->UE->contains($uE)) {
            $this->UE->removeElement($uE);
        }

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
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
        }

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function __toString()
    {
        return $this->getRFID()->getNom() . ' ' . $this->getRFID()->getPrenom();
    }
}
