<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnneeRepository")
 */
class Annee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debutPromotion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $finPromotion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Promotion", mappedBy="annee")
     */
    private $promotions;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutPromotion(): ?\DateTimeInterface
    {
        return $this->debutPromotion;
    }

    public function setDebutPromotion(?\DateTimeInterface $debutPromotion): self
    {
        $this->debutPromotion = $debutPromotion;

        return $this;
    }

    public function getFinPromotion(): ?\DateTimeInterface
    {
        return $this->finPromotion;
    }

    public function setFinPromotion(?\DateTimeInterface $finPromotion): self
    {
        $this->finPromotion = $finPromotion;

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
            $promotion->setAnnee($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
            // set the owning side to null (unless already changed)
            if ($promotion->getAnnee() === $this) {
                $promotion->setAnnee(null);
            }
        }

        return $this;
    }
}
