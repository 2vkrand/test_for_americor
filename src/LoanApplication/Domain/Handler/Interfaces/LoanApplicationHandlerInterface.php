<?php

namespace App\LoanApplication\Domain\Handler\Interfaces;

use App\LoanApplication\Domain\Entity\LoanApplication;

interface LoanApplicationHandlerInterface
{
    public function setNext(LoanApplicationHandlerInterface $handler): LoanApplicationHandlerInterface;

    public function handle(LoanApplication $application): LoanApplication;
}
