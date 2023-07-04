<?php

namespace App\Entity;

use App\Repository\AnnoncesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AnnoncesRepository::class)]
#[Vich\Uploadable]
class Annonces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'annonces', fileNameProperty: 'image')]
    private ?File $imageFile = null;


    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $nbrvus = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    private ?User $user = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getNbrvus(): ?int
    {
        return $this->nbrvus;
    }

    public function setNbrvus(int $nbrvus): static
    {
        $this->nbrvus = $nbrvus;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }





    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        // if (null !== $imageFile) {
        //     It is required that at least one field changes if you are using doctrine
        //     otherwise the event listeners won't be called and the file is lost
        //     $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
}
