<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;

class StateHandler extends AbstractLoanApplicationHandler
{
    /**
     * @var array|string[]
     */
    private array $allowedStates = ['CA', 'NY', 'NV'];

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
        return !in_array($application->getClientInfo()->getState(), $this->allowedStates, true);
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
