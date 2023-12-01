<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $name = null;

	#[ORM\Column(type: Types::DATE_MUTABLE)]
	private ?DateTimeInterface $start = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	private ?DateTimeInterface $end = null;

	#[ORM\Column(type: Types::TEXT, nullable: true)]
	private ?string $description_fr = null;

	#[ORM\Column(length: 255)]
	private ?string $enterprise = null;

	#[ORM\Column(length: 255)]
	private ?string $image = null;

	#[ORM\Column(length: 255)]
	private ?string $url = null;

	#[ORM\Column(type: Types::TEXT)]
	private ?string $description_en = null;

	#[ORM\Column(length: 255)]
	private ?string $keywords = null;

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

	public function getStart(): ?DateTimeInterface
	{
		return $this->start;
	}

	public function setStart(DateTimeInterface $start): static
	{
		$this->start = $start;

		return $this;
	}

	public function getEnd(): ?DateTimeInterface
	{
		return $this->end;
	}

	public function setEnd(?DateTimeInterface $end): static
	{
		$this->end = $end;

		return $this;
	}

	public function getDescriptionFr(): ?string
	{
		return $this->description_fr;
	}

	public function setDescriptionFr(?string $description_fr): static
	{
		$this->description_fr = $description_fr;

		return $this;
	}

	public function getEnterprise(): ?string
	{
		return $this->enterprise;
	}

	public function setEnterprise(string $enterprise): static
	{
		$this->enterprise = $enterprise;

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

	public function getUrl(): ?string
	{
		return $this->url;
	}

	public function setUrl(string $url): static
	{
		$this->url = $url;

		return $this;
	}

	public function getDescriptionEn(): ?string
	{
		return $this->description_en;
	}

	public function setDescriptionEn(string $description_en): static
	{
		$this->description_en = $description_en;

		return $this;
	}

	public function getKeywords(): ?string
	{
		return $this->keywords;
	}

	public function setKeywords(string $keywords): static
	{
		$this->keywords = $keywords;

		return $this;
	}
}
