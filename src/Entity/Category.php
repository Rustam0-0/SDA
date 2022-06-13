<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Subcat::class, mappedBy="category")
     */
    private $subcats;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    public function __construct()
    {
        $this->subcats = new ArrayCollection();
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

    /**
     * @return Collection<int, Subcat>
     */
    public function getSubcats(): Collection
    {
        return $this->subcats;
    }

    public function addSubcat(Subcat $subcat): self
    {
        if (!$this->subcats->contains($subcat)) {
            $this->subcats[] = $subcat;
            $subcat->setCategory($this);
        }

        return $this;
    }

    public function removeSubcat(Subcat $subcat): self
    {
        if ($this->subcats->removeElement($subcat)) {
            // set the owning side to null (unless already changed)
            if ($subcat->getCategory() === $this) {
                $subcat->setCategory(null);
            }
        }

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
}