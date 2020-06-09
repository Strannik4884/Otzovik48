<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable()
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_date;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $thumbnailName;

    /**
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {
     *         "image/jpeg",
     *         "image/gif",
     *         "image/png",
     *     }
     * )
     * @Vich\UploadableField(mapping="products_thumbnails", fileNameProperty="thumbnailName")
     */
    private $thumbnailFile;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="for_product", cascade={"remove"})
     */
    private $comments;

    public function __construct()
    {
        $this->created_date = new \DateTime();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDateValue()
    {
        $this->created_date = new \DateTime();
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setForProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getForProduct() === $this) {
                $comment->setForProduct(null);
            }
        }

        return $this;
    }

    public function getCommentsCount(): int
    {
        return $this->comments->count();
    }

    public function getRating() : int
    {
        $count = 0;
        foreach ($this->comments as $comment){
            $count += $comment->getRating();
        }
        if($this->getCommentsCount() == 0){
            return 0;
        }
        return (int) $count / $this->getCommentsCount();
    }

    public function getThumbnailFile()
    {
        return $this->thumbnailFile;
    }

    /**
     * @param $thumbnailFile
     */
    public function setThumbnailFile($thumbnailFile): void
    {
        $this->thumbnailFile = $thumbnailFile;
    }

    public function getThumbnailName(): ?string
    {
        return $this->thumbnailName;
    }

    public function setThumbnailName(?string $thumbnailName): self
    {
        $this->thumbnailName = $thumbnailName;

        return $this;
    }

    public function getThumbnailFileFullPath(): string
    {
        return '/uploads/' . $this->getThumbnailName();
    }

    public function __toString()
    {
        return $this->name;
    }
}
