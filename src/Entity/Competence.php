<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
	#[ORM\Id]
         	#[ORM\GeneratedValue]
         	#[ORM\Column]
         	private ?int $id = null;

	#[ORM\Column(length: 255)]
         	private ?string $name = null;

	#[ORM\ManyToOne(inversedBy: 'competences')]
         	#[ORM\JoinColumn(nullable: false)]
         	private ?Categorie $categorie = null;

	#[ORM\Column(type: Types::SMALLINT, nullable: true)]
         	private ?int $width = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

	public function getId(): ?int
         	{
         		return $this->id;
         	}

	public function getName(): ?string
         	{
         		return $this->name;
         	}

	public function setName(string $name): static
         	{
         		$this->name = $name;
         
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

	public function getWidth(): ?int
         	{
         		return $this->width;
         	}

	public function setWidth(?int $width): static
         	{
         		$this->width = $width;
         
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
}
