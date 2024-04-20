<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PieceRepository::class)
 */
class Piece
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Qualite;
   
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantite;

    /**
     * @ORM\Column(type="integer")
     */
    private $Prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->Qualite;
    }

    public function setQualite(string $Qualité): self
    {
        $this->Qualite= $Qualité;

        return $this;
    }

    public function getRéférence(): ?string
    {
        return $this->reference;
    }

    public function setRéférence(string $Référence): self
    {
        $this->reference = $Référence;

        return $this;
    }

    public function getQuantité(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantité(int $Quantité): self
    {
        $this->Quantite = $Quantité;

        return $this;
    }
    public function getPrix(): ?int
    {
        return $this->Prix;
    }
    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }
    
}
