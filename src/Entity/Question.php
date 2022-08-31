<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['Question:Read']],

)]

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["Question:Read"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["Question:Read"])]
    private ?string $text = null;

    #[ORM\Column(length: 255)]
    #[Groups(["Question:Read"])]
    private ?string $category = null;

    #[ORM\ManyToMany(targetEntity: Response::class)]
    #[Groups(["Question:Read"])]
    private Collection $responses;

    #[ORM\Column]
    #[Groups(["Question:Read"])]
    private ?int $serial = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $img = null;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        $this->responses->removeElement($response);

        return $this;
    }

    public function getSerial(): ?int
    {
        return $this->serial;
    }

    public function setSerial(int $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    //Ajout de cette méthode pour pouvoir écrire la question
    public function getQuestion()
    {
        return $this->getText();
    }
}
