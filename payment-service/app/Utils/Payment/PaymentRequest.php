<?php

namespace App\Utils\Payment;

class PaymentRequest
{
    private float $amount;
    private string $cardNumber;
    private string $currency;
    private string $ccv;
    private string $expiryDate;
    private string $name;
    private array $headers;

    // Setters
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setCcv(string $ccv): self
    {
        $this->ccv = $ccv;
        return $this;
    }

    public function setExpiryDate(string $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    // Getters
    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCcv(): string
    {
        return $this->ccv;
    }

    public function getExpiryDate(): string
    {
        return $this->expiryDate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders($headers): self
    {
        $this->headers = $headers;
        return $this;
    }
    // Validation
    public function validate(): void
    {
        if (!preg_match('/^\d{16}$/', $this->cardNumber)) {
            throw new \InvalidArgumentException('Invalid card number.');
        }

        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than zero.');
        }

        if (empty($this->currency)) {
            throw new \InvalidArgumentException('Currency cannot be empty.');
        }

        if (empty($this->ccv) || !preg_match('/^\d{3,4}$/', $this->ccv)) {
            throw new \InvalidArgumentException('Invalid CCV.');
        }

        if (empty($this->expiryDate)) {
            throw new \InvalidArgumentException('Expiry date cannot be empty.');
        }

        if (empty($this->name)) {
            throw new \InvalidArgumentException('Name cannot be empty.');
        }
    }
}
