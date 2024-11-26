<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;

class IncomeHandler extends AbstractLoanApplicationHandler
{
    /**
     * @var float
     */
    private float $minIncome = 1000.00;

    /**
     * @param LoanStatusServiceInterface $loanStatusService
     */
    public function __construct(
        private readonly LoanStatusServiceInterface $loanStatusService,
    )
    {}

    /**
     * @param LoanApplication $application
     * @return bool
     */
    protected function canHandle(LoanApplication $application): bool
    {
        return $application->getClientInfo()->getIncome() < $this->minIncome;
    }

    /**
     * @param LoanApplication $application
     * @return LoanApplication
     */
    protected function process(LoanApplication $application): LoanApplication
    {
        return $this->loanStatusService->reject($application);
    }
}
