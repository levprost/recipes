<?php

namespace App\Entity;

use App\Repository\StepRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $stepContent = null;

    #[ORM\ManyToOne(inversedBy: 'step')]
    private ?Post $post = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepContent(): ?string
    {
        return $this->stepContent;
    }

    public function setStepContent(string $stepContent): static
    {
        $this->stepContent = $stepContent;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }
}
