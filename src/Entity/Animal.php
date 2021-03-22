<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("animal_list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Groups("animal_list")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("animal_list")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Groups("animal_list")
     */
    private $gender;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * 
     * @Groups("animal_list")
     */
    private $cohabitation;

    /**
     * @ORM\Column(type="text")
     * 
     * @Groups("animal_list")
     */
    private $picture;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Groups("animal_list")
     */
    private $status;

    /**
     * @ORM\Column(type="text")
     * 
     * @Groups("animal_list")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("animal_list")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("animal_list")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class, inversedBy="animals")
     * 
     * @Groups("animal_list")
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity=Shelter::class, inversedBy="animals")
     * 
     * @Groups("animal_list")
     */
    private $shelter;

    /**
     * @ORM\ManyToOne(targetEntity=Species::class, inversedBy="animal")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $species;

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

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCohabitation(): ?int
    {
        return $this->cohabitation;
    }

    public function setCohabitation(?int $cohabitation): self
    {
        $this->cohabitation = $cohabitation;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getShelter(): ?Shelter
    {
        return $this->shelter;
    }

    public function setShelter(?Shelter $shelter): self
    {
        $this->shelter = $shelter;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): self
    {
        $this->species = $species;

        return $this;
    }
}
