<?php

namespace App\LoanApplication\Domain\Builder;

use App\LoanApplication\Domain\Handler\AgeHandler;
use App\LoanApplication\Domain\Handler\FicoScoreHandler;
use App\LoanApplication\Domain\Handler\IncomeHandler;
use App\LoanApplication\Domain\Handler\Interfaces\LoanApplicationHandlerInterface;
use App\LoanApplication\Domain\Handler\StateHandler;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;

readonly class CheckApplicationHandlerChainBuilder
{
    /**
     * @param LoanStatusServiceInterface $loanStatusService
     */
    public function __construct(
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

        $ageHandler
            ->setNext($incomeHandler)
            ->setNext($ficoScoreHandler)
            ->setNext($stateHandler);

        return $ageHandler;
    }
}