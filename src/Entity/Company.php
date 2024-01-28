<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company extends User
{
    /*#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;*/
 

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['companies', 'industries'])]
    private ?string $name = null;

    #[ORM\Column(length: 64)]
    #[Groups(['companies', 'industries'])]
    private ?string $region = null;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[ORM\Column(type: Types::BIGINT)]
    #[Groups(['companies', 'industries'])]
    private ?string $siret_number = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['companies', 'industries'])]
    private ?string $linkedin = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['companies', 'industries'])]
    private ?string $description = null;

    /*#[ORM\OneToOne(inversedBy: 'company', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;*/

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Offer::class, orphanRemoval: true)]
    private Collection $offers;

    #[ORM\ManyToMany(targetEntity: Industry::class, inversedBy: 'company')]
    private Collection $industries;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->industries = new ArrayCollection();
        $this->setCreatedAt(new DateTimeImmutable());
    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getSiretNumber(): ?string
    {
        return $this->siret_number;
    }

    public function setSiretNumber(string $siret_number): static
    {
        $this->siret_number = $siret_number;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): static
    {
        $this->linkedin = $linkedin;

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

    /*public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }*/

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): static
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setCompany($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getCompany() === $this) {
                $offer->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Industry>
     */
    public function getIndustries(): Collection
    {
        return $this->industries;
    }

    public function addIndustry(Industry $industry): static
    {
        if (!$this->industries->contains($industry)) {
            $this->industries->add($industry);
            $industry->addCompany($this);
        }

        return $this;
    }

    public function removeIndustry(Industry $industry): static
    {
        if ($this->industries->removeElement($industry)) {
            $industry->removeCompany($this);
        }

        return $this;
    }
}
