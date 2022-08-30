<?php

namespace App\Entity;

use App\Repository\TableauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableauRepository::class)]
class Tableau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url = null;

    #[ORM\ManyToMany(targetEntity: Memoire::class, mappedBy: 'tableaux')]
    private Collection $memoires;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $imageUrl = null;

    public function __construct()
    {
        $this->memoires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Memoire>
     */
    public function getMemoires(): Collection
    {
        return $this->memoires;
    }

    public function addMemoire(Memoire $memoire): self
    {
        if (!$this->memoires->contains($memoire)) {
            $this->memoires->add($memoire);
            $memoire->addtableaux($this);
        }

        return $this;
    }

    public function removeMemoire(Memoire $memoire): self
    {
        if ($this->memoires->removeElement($memoire)) {
            $memoire->removetableaux($this);
        }

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
