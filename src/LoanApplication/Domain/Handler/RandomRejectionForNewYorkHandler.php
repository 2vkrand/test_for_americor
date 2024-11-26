<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;
use App\LoanApplication\Domain\Service\RandomGeneratorInterface;

class RandomRejectionForNewYorkHandler extends AbstractLoanApplicationHandler
{
    /**
     * @param LoanStatusServiceInterface $loanStatusService
     * @param RandomGeneratorInterface $randomGenerator
     */
    public function __construct(
        private readonly LoanStatusServiceInterface $loanStatusService,
        private readonly RandomGeneratorInterface $randomGenerator
    )
    {}

    /**
     * @param LoanApplication $application
     * @return bool
     */
    protected function canHandle(LoanApplication $application): bool
    {
        return $application->getClientInfo()->getState() === 'NY' && $this->randomGenerator->generate() === 0;
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
