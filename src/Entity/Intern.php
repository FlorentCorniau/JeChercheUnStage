<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InternRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InternRepository::class)]
class Intern extends User
{
    /*#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;*/

    #[ORM\Column(length: 64)]
    #[Groups(['interns', 'industries'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 64)]
    #[Groups(['interns', 'industries'])]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['interns', 'industries'])]
    private ?string $description = null;

    #[ORM\Column(length: 64)]
    #[Groups(['interns', 'industries'])]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['interns', 'industries'])]
    private ?string $linkedin = null;

    //#[Groups(['intern', 'industries'])]
    private ?File $resumeFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['interns', 'industries'])]
    private ?string $resume_name = null;

    //#[Groups(['intern', 'industries'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['interns', 'industries'])]
    private ?string $picture_name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['interns', 'industries'])]
    private ?\DateTimeImmutable $birthdate = null;

    /*#[ORM\OneToOne(inversedBy: 'intern', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;*/

    #[ORM\ManyToMany(targetEntity: Offer::class, mappedBy: 'intern')]
    private Collection $offers;

  
    // On a iversé le inversedBy et le mappedBy pour que ca save bien en BDD la relation

    #[ORM\ManyToMany(targetEntity: Industry::class, inversedBy: 'intern')]
    private Collection $industries;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->industries = new ArrayCollection();
        $this->setCreatedAt(new DateTimeImmutable());
    }

    /*public function getId(): ?int
    {
        return $this->id;
    }*/

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

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

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

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

    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeImmutable $birthdate): static
    {
        $this->birthdate = $birthdate;

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
            $offer->addIntern($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        if ($this->offers->removeElement($offer)) {
            $offer->removeIntern($this);
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
            $industry->addIntern($this);
        }

        return $this;
    }

    /*public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }*/

    public function removeIndustry(Industry $industry): static
    {
        if ($this->industries->removeElement($industry)) {
            $industry->removeIntern($this);
        }

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    // public function setImageSize(?int $imageSize): void
    // {
    //     $this->imageSize = $imageSize;
    // }

    // public function getImageSize(): ?int
    // {
    //     return $this->imageSize;
    // }

    /**
     * Get the value of picture_name
     *
     * @return ?string
     */
    public function getPictureName(): ?string
    {
        return $this->picture_name;
    }

    /**
     * Set the value of picture_name
     *
     * @param ?string $picture_name
     *
     * @return self
     */
    public function setPictureName(?string $picture_name): self
    {
        $this->picture_name = $picture_name;

        return $this;
    }

    /**
     * Get the value of resumeFile
     *
     * @return ?File
     */
    public function getResumeFile(): ?File
    {
        return $this->resumeFile;
    }

    /**
     * Set the value of resumeFile
     *
     * @param ?File $resumeFile
     *
     * @return self
     */
    public function setResumeFile(?File $resumeFile): self
    {
        $this->resumeFile = $resumeFile;

        return $this;
    }

    /**
     * Get the value of resume_name
     *
     * @return ?string
     */
    public function getResumeName(): ?string
    {
        return $this->resume_name;
    }

    /**
     * Set the value of resume_name
     *
     * @param ?string $resume_name
     *
     * @return self
     */
    public function setResumeName(?string $resume_name): self
    {
        $this->resume_name = $resume_name;

        return $this;
    }
}
