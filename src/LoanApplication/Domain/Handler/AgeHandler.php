<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;

class AgeHandler extends AbstractLoanApplicationHandler
{
    /**
     * @var int
     */
    private int $minAge = 18;
    /**
     * @var int
     */
    private int $maxAge = 60;

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
        $age = $application->getClientInfo()->getAge();
        return $age < $this->minAge || $age > $this->maxAge;
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
