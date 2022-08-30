<?php

namespace App\Entity;

use App\Repository\RiasecRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    collectionOperations: ['get','post'],
    itemOperations: ['get','put'],
)]

#[ORM\Entity(repositoryClass: RiasecRepository::class)]
class Riasec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $realiste = null;

    #[ORM\Column]
    private ?int $investigateur = null;

    #[ORM\Column]
    private ?int $artistique = null;

    #[ORM\Column]
    private ?int $social = null;

    #[ORM\Column]
    private ?int $entreprenant = null;

    #[ORM\Column]
    private ?int $conventionnel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRealiste(): ?int
    {
        return $this->realiste;
    }

    public function setRealiste(int $realiste): self
    {
        $this->realiste = $realiste;

        return $this;
    }

    public function getInvestigateur(): ?int
    {
        return $this->investigateur;
    }

    public function setInvestigateur(int $investigateur): self
    {
        $this->investigateur = $investigateur;

        return $this;
    }

    public function getArtistique(): ?int
    {
        return $this->artistique;
    }

    public function setArtistique(int $artistique): self
    {
        $this->artistique = $artistique;

        return $this;
    }

    public function getSocial(): ?int
    {
        return $this->social;
    }

    public function setSocial(int $social): self
    {
        $this->social = $social;

        return $this;
    }

    public function getEntreprenant(): ?int
    {
        return $this->entreprenant;
    }

    public function setEntreprenant(int $entreprenant): self
    {
        $this->entreprenant = $entreprenant;

        return $this;
    }

    public function getConventionnel(): ?int
    {
        return $this->conventionnel;
    }

    public function setConventionnel(int $conventionnel): self
    {
        $this->conventionnel = $conventionnel;

        return $this;
    }
}
