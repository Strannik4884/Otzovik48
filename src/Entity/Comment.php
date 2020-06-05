<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $by_user;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $for_product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreateDate(\DateTimeInterface $createdDate): self
    {
        $this->created_date = $createdDate;

        return $this;
    }

    public function getByUser(): ?User
    {
        return $this->by_user;
    }

    public function setByUser(?User $by_user): self
    {
        $this->by_user = $by_user;

        return $this;
    }

    public function getForProduct(): ?Product
    {
        return $this->for_product;
    }

    public function setForProduct(?Product $for_product): self
    {
        $this->for_product = $for_product;

        return $this;
    }

    public function __toString()
    {
        return $this->by_user;
    }
}
