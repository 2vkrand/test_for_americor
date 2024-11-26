<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;

class ApprovalHandler extends AbstractLoanApplicationHandler
{
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
        return $application->getStatus() === LoanApplication::PENDING_STATUS;
    }

    /**
     * @param LoanApplication $application
     * @return LoanApplication
     */
    protected function process(LoanApplication $application): LoanApplication
    {
        return $this->loanStatusService->approve($application);
    }
}
