<?php

namespace App\DTO;
Use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class AdresseDTO 
{
    /**
     * @OA\Property(type="integer")
     *
     * @var int|null
     */
    private $id;

    /**
     * @OA\Property(type="string")
     *
     * @var string|null
     */
    private $denomination;

    /**
     * @OA\Property(type="string")
     *
     * @var string|null
     */
    private $libelleVoie;

    /**
     * @OA\Property(type="string")
     *
     * @var string|null
     */
    private $ville;

    /**
     * @OA\Property(type="string")
     *
     * @var string|null
     */
    private $pays;

    /**
     * @OA\Property(type="string")
     *
     * @var string|null
     */
    private $codePostal;

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
    public function setId(?int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of libelleVoie
     */ 
    public function getLibelleVoie():?string
    {
        return $this->libelleVoie;
    }

    /**
     * Set the value of libelleVoie
     *
     * @return  self
     */ 
    public function setLibelleVoie(?string $libelleVoie):self
    {
        $this->libelleVoie = $libelleVoie;

        return $this;
    }

    /**
     * Get the value of ville
     */ 
    public function getVille():?string
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */ 
    public function setVille(?string $ville):self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get the value of pays
     */ 
    public function getPays():?string
    {
        return $this->pays;
    }

    /**
     * Set the value of pays
     *
     * @return  self
     */ 
    public function setPays(?string $pays):self
    {
        $this->pays = $pays;

        return $this;
    }

    public function __toString()
    {
        return
        $this->id .
        $this->libelleVoie .
        $this->ville .
        $this->codePostal .
        $this->pays;
    }

    /**
     * Get the value of denomination
     *
     * @return  string
     */ 
    public function getDenomination():?string
    {
        return $this->denomination;
    }

    /**
     * Set the value of denomination
     *
     * @param  string  $denomination
     *
     * @return  self
     */ 
    public function setDenomination(?string $denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get the value of codePostal
     *
     * @return  string|null
     */ 
    public function getCodePostal():?string
    {
        return $this->codePostal;
    }

    /**
     * Set the value of codePostal
     *
     * @param  string|null  $codePostal
     *
     * @return  self
     */ 
    public function setCodePostal(?string $codePostal):self
    {
        $this->codePostal = $codePostal;

        return $this;
    }
}