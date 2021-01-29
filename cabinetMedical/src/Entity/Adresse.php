<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $denomination;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $libelleVoie;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity=Praticien::class, mappedBy="adresse")
     */
    private $praticien;

    public function __construct()
    {
        $this->praticien = new ArrayCollection();
    }

    public function __toString():string
    {
        return
        $this->libelleVoie .
        $this->ville .
        $this->pays;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getLibelleVoie(): ?string
    {
        return $this->libelleVoie;
    }

    public function setLibelleVoie(?string $libelleVoie): self
    {
        $this->libelleVoie = $libelleVoie;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|Praticien[]
     */
    public function getPraticien(): Collection
    {
        return $this->praticien;
    }

    public function addPraticien(Praticien $praticien): self
    {
        if (!$this->praticien->contains($praticien)) {
            $this->praticien[] = $praticien;
            $praticien->setAdresse($this);
        }

        return $this;
    }

    public function removePraticien(Praticien $praticien): self
    {
        if ($this->praticien->removeElement($praticien)) {
            // set the owning side to null (unless already changed)
            if ($praticien->getAdresse() === $this) {
                $praticien->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of denomination
     */ 
    public function getDenomination():string
    {
        return $this->denomination;
    }

    /**
     * Set the value of denomination
     *
     * @return  self
     */ 
    public function setDenomination(?string $denomination):self
    {
        $this->denomination = $denomination;

        return $this;
    }
}
