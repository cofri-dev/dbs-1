<?php

namespace App\Entity;

use App\Repository\WorkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkRepository::class)]
class Work
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateChantier = null;

    #[ORM\OneToMany(mappedBy: 'imagesOfWork', targetEntity: Image::class, orphanRemoval: true, cascade:["persist"])]
    private Collection $workImages;

    public function __construct()
    {
        $this->workImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getDateChantier(): ?\DateTimeInterface
    {
        return $this->dateChantier;
    }

    public function setDateChantier(\DateTimeInterface $dateChantier): self
    {
        $this->dateChantier = $dateChantier;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getWorkImages(): Collection
    {
        return $this->workImages;
    }

    public function addWorkImage(Image $workImage): self
    {
        if (!$this->workImages->contains($workImage)) {
            $this->workImages->add($workImage);
            $workImage->setImagesOfWork($this);
        }

        return $this;
    }

    public function removeWorkImage(Image $workImage): self
    {
        if ($this->workImages->removeElement($workImage)) {
            // set the owning side to null (unless already changed)
            if ($workImage->getImagesOfWork() === $this) {
                $workImage->setImagesOfWork(null);
            }
        }

        return $this;
    }

}
