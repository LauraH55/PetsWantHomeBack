<?php

namespace App\Entity;

use App\Repository\ShelterRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ShelterRepository::class)
 * @UniqueEntity("address")
 * @UniqueEntity("phoneNumber")
 */
class Shelter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("shelter_list")
     * @Groups("animal_list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Assert\NotBlank
     * 
     * @Groups("shelter_list")
     * @Groups("animal_list")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     * @Groups("shelter_list")
     * @Groups("animal_list")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10)
     * 
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      minMessage = "Votre numéro de téléphone est incorrect",
     *      maxMessage = "Votre numéro de téléphone est incorrect"
     * )
     * @Assert\Regex("/^[0-9]*$/", message="Votre numéro de téléphone est incorrect")
     * @Assert\NotBlank
     * 
     * @Groups("shelter_list")
     * @Groups("animal_list")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Groups("shelter_list")
     * @Groups("animal_list")
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Assert\NotBlank(message="L'image doit être au format PNG ou JPEG, et ne pas dépasser 4096k.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * 
     * @Groups("shelter_list")
     * @Groups("animal_list")
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Groups("shelter_list")
     * @Groups("animal_list")
     */
    private $rnaNumber;

    /**
     * @ORM\OneToMany(targetEntity=Animal::class, mappedBy="shelter")
     * 
     * @Groups("shelter_list")
     * 
     * 
     */
    private $animals;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="shelter", cascade={"persist", "remove"})
     * 
     * @Groups("shelter_list")
     * 
     */
    private $user;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getRnaNumber(): ?string
    {
        return $this->rnaNumber;
    }

    public function setRnaNumber(?string $rnaNumber): self
    {
        $this->rnaNumber = $rnaNumber;

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setShelter($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getShelter() === $this) {
                $animal->setShelter(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
