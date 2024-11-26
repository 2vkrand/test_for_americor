<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;

class CaliforniaInterestRateAdjustmentHandler extends AbstractLoanApplicationHandler
{
    /**
     * @var float
     */
    private float $extraRate = 11.49;

    /**
     * @param LoanApplication $application
     * @return bool
     */
    protected function canHandle(LoanApplication $application): bool
    {
        return $application->getClientInfo()->getState() === 'CA';
    }

    /**
     * @param LoanApplication $application
     * @return LoanApplication
     */
    protected function process(LoanApplication $application): LoanApplication
    {
        $productInfo = $application->getProductInfo();
        $newRate = $productInfo->getInterestRate() + $this->extraRate;

        $productInfo->setInterestRate($newRate);

        return $application;
    }
}
