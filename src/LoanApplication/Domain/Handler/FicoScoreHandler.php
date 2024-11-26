<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;

/**
 *
 */
class FicoScoreHandler extends AbstractLoanApplicationHandler
{
    /**
     * @var int
     */
    private int $minFicoScore = 500;

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
        return $application->getClientInfo()->getFicoScore() <= $this->minFicoScore;
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
