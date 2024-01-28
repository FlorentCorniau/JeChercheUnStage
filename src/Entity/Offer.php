<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['offers', 'industries'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['offers', 'industries'])]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    #[Groups(['offers', 'industries'])]
    private ?string $company_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['offers', 'industries'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['offers', 'industries'])]
    private ?int $duration = null;

    #[ORM\Column(length: 64)]
    #[Groups(['offers', 'industries'])]
    private ?string $region = null;

    #[ORM\Column]
    #[Groups(['offers', 'industries'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['offers', 'industries'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Intern::class, inversedBy: 'offers')]
    private Collection $intern;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Industry $industry = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    public function __construct()
    {
        // ! ici j'ai ajouté createAt pour pas avoir à l'ajouter par le user dans le formulaire de création d'une offre de stage
        $this->intern = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
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

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): static
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Intern>
     */
    public function getIntern(): Collection
    {
        return $this->intern;
    }

    public function addIntern(Intern $intern): static
    {
        if (!$this->intern->contains($intern)) {
            $this->intern->add($intern);
        }

        return $this;
    }

    public function removeIntern(Intern $intern): static
    {
        $this->intern->removeElement($intern);

        return $this;
    }

    public function getIndustry(): ?Industry
    {
        return $this->industry;
    }

    public function setIndustry(?Industry $industry): static
    {
        $this->industry = $industry;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }
}
