<?php

namespace App\Entity;

use App\Repository\BooksAndRentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BooksAndRentsRepository::class)]
class BooksAndRents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    private $isbn;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $author;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $publisher;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $sub_title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $category;

    #[ORM\Column(type: 'string', length: 1300, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $cover;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $language;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $relase_date;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $rent_started_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $rent_ended_at;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $is_rented;

    #[ORM\Column(type: 'float', nullable: true)]
    private $rent_price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->sub_title;
    }

    public function setSubTitle(?string $sub_title): self
    {
        $this->sub_title = $sub_title;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getRelaseDate(): ?string
    {
        return $this->relase_date;
    }

    public function setRelaseDate(?string $relase_date): self
    {
        $this->relase_date = $relase_date;

        return $this;
    }

    public function getRentStartedAt(): ?\DateTimeInterface
    {
        return $this->rent_started_at;
    }

    public function setRentStartedAt(?\DateTimeInterface $rent_started_at): self
    {
        $this->rent_started_at = $rent_started_at;

        return $this;
    }

    public function getRentEndedAt(): ?\DateTimeInterface
    {
        return $this->rent_ended_at;
    }

    public function setRentEndedAt(?\DateTimeInterface $rent_ended_at): self
    {
        $this->rent_ended_at = $rent_ended_at;

        return $this;
    }

    public function getIsRented(): ?int
    {
        return $this->is_rented;
    }

    public function setIsRented(?int $is_rented): self
    {
        $this->is_rented = $is_rented;

        return $this;
    }

    public function getRentPrice(): ?float
    {
        return $this->rent_price;
    }

    public function setRentPrice(?float $rent_price): self
    {
        $this->rent_price = $rent_price;

        return $this;
    }
}
