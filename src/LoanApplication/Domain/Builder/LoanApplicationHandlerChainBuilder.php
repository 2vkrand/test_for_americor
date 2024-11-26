<?php

namespace App\LoanApplication\Domain\Builder;

use App\LoanApplication\Domain\Handler\AgeHandler;
use App\LoanApplication\Domain\Handler\IncomeHandler;
use App\LoanApplication\Domain\Handler\FicoScoreHandler;
use App\LoanApplication\Domain\Handler\StateHandler;
use App\LoanApplication\Domain\Handler\RandomRejectionForNewYorkHandler;
use App\LoanApplication\Domain\Handler\CaliforniaInterestRateAdjustmentHandler;
use App\LoanApplication\Domain\Handler\ApprovalHandler;
use App\LoanApplication\Domain\Handler\Interfaces\LoanApplicationHandlerInterface;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;
use App\LoanApplication\Domain\Service\RandomGeneratorInterface;

readonly class LoanApplicationHandlerChainBuilder
{
    /**
     * @param RandomGeneratorInterface $randomGenerator
     * @param LoanStatusServiceInterface $loanStatusService
     */
    public function __construct(
        private RandomGeneratorInterface $randomGenerator,
        private LoanStatusServiceInterface $loanStatusService,
    )
    {}

    /**
     * @return LoanApplicationHandlerInterface
     */
    public function build(): LoanApplicationHandlerInterface
    {
        $ageHandler = new AgeHandler($this->loanStatusService);
        $incomeHandler = new IncomeHandler($this->loanStatusService);
        $ficoScoreHandler = new FicoScoreHandler($this->loanStatusService);
        $stateHandler = new StateHandler($this->loanStatusService);
        $nyHandler = new RandomRejectionForNewYorkHandler($this->loanStatusService, $this->randomGenerator);
        $caRateAdjustmentHandler = new CaliforniaInterestRateAdjustmentHandler();
        $approvalHandler = new ApprovalHandler($this->loanStatusService);

        $ageHandler
            ->setNext($incomeHandler)
            ->setNext($ficoScoreHandler)
            ->setNext($stateHandler)
            ->setNext($nyHandler)
            ->setNext($caRateAdjustmentHandler)
            ->setNext($approvalHandler);

        return $ageHandler;
    }
}

