<?php

namespace App\LoanApplication\Domain\DTO;

use InvalidArgumentException;

readonly class ClientInfoDTO
{
    /**
     * @param int $age
     * @param float $income
     * @param int $ficoScore
     * @param string $state
     * @param string $email
     * @param string $phoneNumber
     */
    public function __construct(
        private int    $age,
        private float  $income,
        private int    $ficoScore,
        private string $state,
        private string $email,
        private string $phoneNumber,
    ) {
        $this->validate();
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return void
     */
    private function validate(): void
    {
        // Допускаем, что клиент может быть моложе 18 лет
        if ($this->age < 16 || $this->age > 120) {
            throw new InvalidArgumentException('Age must be between 16 and 120.');
        }

        if ($this->income < 0) {
            throw new InvalidArgumentException('Income must be a positive number.');
        }

        if ($this->ficoScore < 300 || $this->ficoScore > 850) {
            throw new InvalidArgumentException('FICO Score must be between 300 and 850.');
        }

        if (empty($this->state) || strlen($this->state) !== 2) {
            throw new InvalidArgumentException('State must be a valid 2-letter code.');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format.');
        }

        if (empty($this->phoneNumber)) {
            throw new InvalidArgumentException('Income must be a positive number.');
        }
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return float
     */
    public function getIncome(): float
    {
        return $this->income;
    }

    /**
     * @return int
     */
    public function getFicoScore(): int
    {
        return $this->ficoScore;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
