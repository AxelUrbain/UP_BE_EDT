<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 */
class Formation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professeur", inversedBy="formations")
     */
    private $professeurResponsable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diplome;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbAnnee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Promotion", mappedBy="formation")
     */
    private $promotions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", inversedBy="formations")
     */
    private $cours;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UE", inversedBy="formations")
     */
    private $UE;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->cours = new ArrayCollection();
        $this->UE = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfesseurResponsable(): ?Professeur
    {
        return $this->professeurResponsable;
    }

    public function setProfesseurResponsable(?Professeur $professeurResponsable): self
    {
        $this->professeurResponsable = $professeurResponsable;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(?string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getNbAnnee(): ?int
    {
        return $this->nbAnnee;
    }

    public function setNbAnnee(?int $nbAnnee): self
    {
        $this->nbAnnee = $nbAnnee;

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
            $promotion->setFormation($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
            // set the owning side to null (unless already changed)
            if ($promotion->getFormation() === $this) {
                $promotion->setFormation(null);
            }
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
}
