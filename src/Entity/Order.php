<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderCode;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $codeImage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $orderDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $costumerName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalAmount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderLines;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderCode(): ?int
    {
        return $this->orderCode;
    }

    public function setOrderCode(int $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getCostumerName(): ?string
    {
        return $this->costumerName;
    }

    public function setCostumerName(string $costumerName): self
    {
        $this->costumerName = $costumerName;

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

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getOrderLines(): ?int
    {
        return $this->orderLines;
    }

    public function setOrderLines(int $orderLines): self
    {
        $this->orderLines = $orderLines;

        return $this;
    }

    public function getCodeImage(): ?string
    {
        return $this->codeImage;
    }

    public function setCodeImage(?string $codeImage): self
    {
        $this->codeImage = $codeImage;

        return $this;
    }


}
