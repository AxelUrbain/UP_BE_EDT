<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IdEtudiantRepository")
 */
class IdEtudiant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RFID", inversedBy="idEtudiant", cascade={"persist", "remove"})
     */
    private $RFID;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion", mappedBy="idEtudiant")
     */
    private $promotions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UE", inversedBy="idEtudiants")
     */
    private $UE;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", inversedBy="idEtudiants")
     */
    private $cours;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
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
     * @return Collection|Promotion[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->addIdEtudiant($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
            $promotion->removeIdEtudiant($this);
        }

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
}
