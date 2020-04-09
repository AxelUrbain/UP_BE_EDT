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
     * @ORM\OneToMany(targetEntity="App\Entity\FormationUE", mappedBy="formation")
     */
    private $formationUEs;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->cours = new ArrayCollection();
        $this->formationUEs = new ArrayCollection();
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

    public function __toString()
    {
        return $this->getDiplome();
    }

    /**
     * @return Collection|FormationUE[]
     */
    public function getFormationUEs(): Collection
    {
        dump($this->formationUEs);
        return $this->formationUEs;
    }

    public function addFormationUE(FormationUE $formationUE): self
    {
        if (!$this->formationUEs->contains($formationUE)) {
            $this->formationUEs[] = $formationUE;
            $formationUE->setFormation($this);
        }

        return $this;
    }

    public function removeFormationUE(FormationUE $formationUE): self
    {
        if ($this->formationUEs->contains($formationUE)) {
            $this->formationUEs->removeElement($formationUE);
            // set the owning side to null (unless already changed)
            if ($formationUE->getFormation() === $this) {
                $formationUE->setFormation(null);
            }
        }

        return $this;
    }
}
