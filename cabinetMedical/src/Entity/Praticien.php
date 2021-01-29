<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PraticienRepository;

/**
 * @ORM\Entity(repositoryClass=PraticienRepository::class)
 */
class Praticien extends User
{
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $specialite;

    /**
     * 
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="praticien",cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="praticien")
     */
    private $rendezVous;

    /**
     * @ORM\OneToMany(targetEntity=Suivre::class, mappedBy="praticien")
     */
    private $suivres;

    public function __construct()
    {
        parent::__construct();
        $this->rendezVous = new ArrayCollection();
        $this->suivres = new ArrayCollection();
    }

    public function __toString()
    {
        return
        $this->specialite;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

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

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|RendezVous[]
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVou(RendezVous $rendezVou): self
    {
        if (!$this->rendezVous->contains($rendezVou)) {
            $this->rendezVous[] = $rendezVou;
            $rendezVou->setPraticien($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): self
    {
        if ($this->rendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getPraticien() === $this) {
                $rendezVou->setPraticien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Suivre[]
     */
    public function getSuivres(): Collection
    {
        return $this->suivres;
    }

    public function addSuivre(Suivre $suivre): self
    {
        if (!$this->suivres->contains($suivre)) {
            $this->suivres[] = $suivre;
            $suivre->setPraticien($this);
        }

        return $this;
    }

    public function removeSuivre(Suivre $suivre): self
    {
        if ($this->suivres->removeElement($suivre)) {
            // set the owning side to null (unless already changed)
            if ($suivre->getPraticien() === $this) {
                $suivre->setPraticien(null);
            }
        }

        return $this;
    }
}
