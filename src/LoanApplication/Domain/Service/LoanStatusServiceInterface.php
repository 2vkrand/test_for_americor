<?php

namespace App\LoanApplication\Domain\Service;

use App\LoanApplication\Domain\Entity\LoanApplication;

interface LoanStatusServiceInterface
{
    public function approve(LoanApplication $loanApplication): LoanApplication;

    public function reject(LoanApplication $loanApplication): LoanApplication;
}
