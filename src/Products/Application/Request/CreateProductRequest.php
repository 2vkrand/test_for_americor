<?php

namespace App\Products\Application\Request;

class CreateProductRequest
{
    /**
     * @var string|mixed
     */
    public string $name;
    /**
     * @var float|mixed
     */
    public float $interestRate;
    /**
     * @var int|mixed
     */
    public int $loanTerm;
    /**
     * @var float|mixed
     */
    public float $loanAmount;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (!isset($data['name'], $data['interestRate'], $data['loanTerm'], $data['loanAmount'])) {
            throw new \InvalidArgumentException('Invalid input data');
        }

        $this->name = $data['name'];
        $this->interestRate = $data['interestRate'];
        $this->loanTerm = $data['loanTerm'];
        $this->loanAmount = $data['loanAmount'];
    }
}
