<?php

namespace App\Products\Domain\ValueObject;

class LoanTerm
{
    /**
     * @var int
     */
    private int $term;

    /**
     * @param int $term
     */
    public function __construct(int $term)
    {
        if ($term <= 0) {
            throw new \InvalidArgumentException('Loan term must be greater than 0.');
        }

        $this->term = $term;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->term;
    }
}
