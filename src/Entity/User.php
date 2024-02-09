<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\OneToMany(targetEntity: Phone::class, mappedBy: 'user', cascade:['persist', 'remove'])]
    private Collection  $Phones;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $Address = null;

    public function __construct()
    {
        $this->Phones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    #[Groups(["user"])]
    public function getPhones(): Collection
    {
        return $this->Phones;
    }

    public function addPhone(Phone $phone): static
    {
        if (!$this->Phones->contains($phone)) {
            $this->Phones->add($phone);
            $phone->setUser($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): static
    {
        if ($this->Phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getUser() === $this) {
                $phone->setUser(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): static
    {
        $this->Address = $Address;

        return $this;
    }
}
