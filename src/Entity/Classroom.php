<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassroomRepository")
 */
class Classroom
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $Capacity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipments", mappedBy="classrooms")
     */
    private $equipments;


    public function __construct()
    {
        $this->equipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->Capacity;
    }

    public function setCapacity(int $Capacity): self
    {
        $this->Capacity = $Capacity;

        return $this;
    }

    /**
     * @return Collection|Equipments[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipments $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->addClassroom($this);
        }

        return $this;
    }

    public function removeEquipment(Equipments $equipment): self
    {
        if ($this->equipments->contains($equipment)) {
            $this->equipments->removeElement($equipment);
            $equipment->removeClassroom($this);
        }

        return $this;
    }

}
