<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $prepTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cookingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $restingTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $recipeQuantity = null;

    #[ORM\Column(length: 255)]
    private ?string $abstract = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $prepaTime = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'post')]
    private Collection $step;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoris')]
    private Collection $favoris;

    public function __construct()
    {
        $this->step = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrepTime(): ?\DateTimeInterface
    {
        return $this->prepTime;
    }

    public function setPrepTime(\DateTimeInterface $prepTime): static
    {
        $this->prepTime = $prepTime;

        return $this;
    }

    public function getCookingTime(): ?\DateTimeInterface
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?\DateTimeInterface $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getRestingTime(): ?\DateTimeInterface
    {
        return $this->restingTime;
    }

    public function setRestingTime(?\DateTimeInterface $restingTime): static
    {
        $this->restingTime = $restingTime;

        return $this;
    }

    public function getRecipeQuantity(): ?int
    {
        return $this->recipeQuantity;
    }

    public function setRecipeQuantity(?int $recipeQuantity): static
    {
        $this->recipeQuantity = $recipeQuantity;

        return $this;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): static
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrepaTime(): ?int
    {
        return $this->prepaTime;
    }

    public function setPrepaTime(?int $prepaTime): static
    {
        $this->prepaTime = $prepaTime;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getStep(): Collection
    {
        return $this->step;
    }

    public function addStep(Step $step): static
    {
        if (!$this->step->contains($step)) {
            $this->step->add($step);
            $step->setPost($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->step->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getPost() === $this) {
                $step->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(User $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(User $favori): static
    {
        $this->favoris->removeElement($favori);

        return $this;
    }
}
