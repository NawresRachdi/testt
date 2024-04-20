<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
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
    private $Marque;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nomclien;
    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $Numero;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Date;


    /**
     * @ORM\ManyToMany(targetEntity=Contact::class, mappedBy="ville")
     */

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getNomclien(): ?string
    {
        return $this->Nomclien;
    }

    public function setNomclien(string $Nomclien): self
    {
        $this->Nomclien = $Nomclien;

        return $this;
    }
    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }
    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(string $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }
    public function getModèle(): ?string
    {
        return $this->Modele;
    }

    public function setModèle(string $Modèle): self
    {
        $this->Modele = $Modèle;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(string $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

}
