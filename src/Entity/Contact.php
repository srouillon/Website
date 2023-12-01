<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $object = null;

	#[ORM\Column(type: Types::TEXT)]
	private ?string $message = null;

	#[ORM\Column(length: 255)]
	#[Assert\Email(message: "This value is not a valid email address.")]
	private ?string $email = null;

	#[ORM\Column(length: 255)]
	private ?string $identity = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $company = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getObject(): ?string
	{
		return $this->object;
	}

	public function setObject(string $object): static
	{
		$this->object = $object;

		return $this;
	}

	public function getMessage(): ?string
	{
		return $this->message;
	}

	public function setMessage(string $message): static
	{
		$this->message = $message;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): static
	{
		$this->email = $email;

		return $this;
	}

	public function getIdentity(): ?string
	{
		return $this->identity;
	}

	public function setIdentity(string $identity): static
	{
		$this->identity = $identity;

		return $this;
	}

	public function getCompany(): ?string
	{
		return $this->company;
	}

	public function setCompany(?string $company): static
	{
		$this->company = $company;

		return $this;
	}
}
