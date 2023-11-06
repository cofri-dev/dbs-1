<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'workImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Work $imagesOfWork = null;

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

    public function getImagesOfWork(): ?Work
    {
        return $this->imagesOfWork;
    }

    public function setImagesOfWork(?Work $imagesOfWork): self
    {
        $this->imagesOfWork = $imagesOfWork;

        return $this;
    }
}
