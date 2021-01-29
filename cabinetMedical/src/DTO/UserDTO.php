<?php

namespace App\DTO;
Use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class UserDTO
{
    private $id;
    private $nom;
    private $prenom;
    private $dateInscription;
    private $email;
    private $telephone;
    private $password;

    /**
     * Get the value of id
     */ 
    public function getId():int
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

    /**
     * Get the value of nom
     */ 
    public function getNom():?string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom(?string $nom):self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom():?string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom(?string $prenom):self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of dateInscription
     */ 
    public function getDateInscription():?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    /**
     * Set the value of dateInscription
     *
     * @return  self
     */ 
    public function setDateInscription(?\DateTimeInterface $dateInscription):self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail():?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(?string $email):self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telephone
     */ 
    public function getTelephone():?int
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */ 
    public function setTelephone(?int $telephone):self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword():?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword(?string $password):self
    {
        $this->password = $password;

        return $this;
    }
}