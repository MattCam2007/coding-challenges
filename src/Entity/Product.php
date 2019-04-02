<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $ProductCategory;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $Sku;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $Price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Quantity;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateModified;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getProductCategory(): ?string
    {
        return $this->ProductCategory;
    }

    public function setProductCategory(?string $ProductCategory): self
    {
        $this->ProductCategory = $ProductCategory;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->Sku;
    }

    public function setSku(?string $Sku): self
    {
        $this->Sku = $Sku;

        return $this;
    }

    public function getPrice()
    {
        return $this->Price;
    }

    public function setPrice($Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(?int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->DateCreated;
    }

    public function setDateCreated(\DateTimeInterface $DateCreated): self
    {
        $this->DateCreated = $DateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->DateModified;
    }

    public function setDateModified(\DateTimeInterface $DateModified): self
    {
        $this->DateModified = $DateModified;

        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'ProductId' => $this->getId(),
            'Name' => $this->getName(),
            'ProductCategoryController' => $this->getProductCategory(),
            'Sku' => $this->getSku(),
            'Price' => $this->getPrice(),
            'Quantity' => $this->getQuantity(),
            'DateCreated' => $this->getDateCreated(),
            'DateModified' => $this->getDateModified(),
        );
    }
}
