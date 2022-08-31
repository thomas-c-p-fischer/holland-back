<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
        collectionOperations: ['get'],
        itemOperations: ['get'],
        normalizationContext: ['groups' => ['Response:Read']],
)]

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["Response:Read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["Response:Read"])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(["Response:Read"])]
    private ?int $weight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
