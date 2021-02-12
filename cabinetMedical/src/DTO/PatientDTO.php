<?php

namespace App\DTO;

use DateTimeInterface;
Use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class PatientDTO 
{
    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $nom;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $prenom;

    /**
     * @OA\Property(
     *      type="string",
     *      format="datetime")
     *
     * @var string
     */
    private $dateInscription;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(type="string")
     *
     * @var int
     */
    private $telephone;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * @OA\Property(
     *      type="string",
     *      format="datetime")
     *
     * @var string
     */
    private $dateNaissance;

    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $role;

    /**
     * Get the value of id
     */ 
    public function getId():?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id): self
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
    public function getDateInscription():?string
    {
        return $this->dateInscription;
    }

    /**
     * Set the value of dateInscription
     *
     * @return  self
     */ 
    public function setDateInscription(?string $dateInscription):self
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
    public function getTelephone():?string
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */ 
    public function setTelephone(?string $telephone):self
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

    /**
     * Get the value of dateNaissance
     */ 
    public function getDateNaissance():?string
    {
        return $this->dateNaissance;
    }

    /**
     * Set the value of dateNaissance
     *
     * @return  self
     */ 
    public function setDateNaissance(?string $dateNaissance):self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    // public function __toString()
    // {
    //     return
    //     $this->id .
    //     $this->nom .
    //     $this->prenom .
    //     $this->dateInscription .
    //     $this->email .
    //     $this->password .
    //     $this->role .
    //     $this->dateNaissance;
    // }

    /**
     * Get the value of role
     *
     * @return  string
     */
    public function getRole():? string
    {
        $role = $this->role;

        $role = 'patient';

        return $role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }
}