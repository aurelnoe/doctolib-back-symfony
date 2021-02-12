<?php

namespace App\Entity;

use DateTime;
use App\Entity\User;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatientRepository;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient extends User
{

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="patient")
     */
    private $rendezVous;

    /**
     * @ORM\OneToMany(targetEntity=Suivre::class, mappedBy="patient")
     */
    private $suivres;

    public function __construct()
    {
        parent::__construct();
        $this->rendezVous = new ArrayCollection();
        $this->suivres = new ArrayCollection();
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {   
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

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
            $rendezVou->setPatient($this);
        }
        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): self
    {
        if ($this->rendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getPatient() === $this) {
                $rendezVou->setPatient(null);
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
            $suivre->setPatient($this);
        }

        return $this;
    }

    public function removeSuivre(Suivre $suivre): self
    {
        if ($this->suivres->removeElement($suivre)) {
            // set the owning side to null (unless already changed)
            if ($suivre->getPatient() === $this) {
                $suivre->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRole():? string
    {
        $role = $this->role;
        // guarantee every user at least has ROLE_USER
        $role = 'patient';

        return $role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
