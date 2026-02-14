<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Street $street = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Owner $owner = null;

    #[ORM\Column(length: 50)]
    private ?string $building_number = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $unit_room = null;

    /**
     * @var Collection<int, WaterMeter>
     */
    #[ORM\OneToMany(targetEntity: WaterMeter::class, mappedBy: 'location')]
    private Collection $waterMeters;

    public function __construct()
    {
        $this->waterMeters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?Street
    {
        return $this->street;
    }

    public function setStreet(?Street $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getBuildingNumber(): ?string
    {
        return $this->building_number;
    }

    public function setBuildingNumber(string $building_number): static
    {
        $this->building_number = $building_number;

        return $this;
    }

    public function getUnitRoom(): ?string
    {
        return $this->unit_room;
    }

    public function setUnitRoom(?string $unit_room): static
    {
        $this->unit_room = $unit_room;

        return $this;
    }

    /**
     * @return Collection<int, WaterMeter>
     */
    public function getWaterMeters(): Collection
    {
        return $this->waterMeters;
    }

    public function addWaterMeter(WaterMeter $waterMeter): static
    {
        if (!$this->waterMeters->contains($waterMeter)) {
            $this->waterMeters->add($waterMeter);
            $waterMeter->setLocation($this);
        }

        return $this;
    }

    public function removeWaterMeter(WaterMeter $waterMeter): static
    {
        if ($this->waterMeters->removeElement($waterMeter)) {
            // set the owning side to null (unless already changed)
            if ($waterMeter->getLocation() === $this) {
                $waterMeter->setLocation(null);
            }
        }

        return $this;
    }
}
