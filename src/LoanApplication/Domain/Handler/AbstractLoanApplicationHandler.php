<?php

namespace App\LoanApplication\Domain\Handler;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Handler\Interfaces\LoanApplicationHandlerInterface;

abstract class AbstractLoanApplicationHandler implements LoanApplicationHandlerInterface
{
    /**
     * @var LoanApplicationHandlerInterface|null
     */
    private ?LoanApplicationHandlerInterface $nextHandler = null;

    /**
     * @param LoanApplicationHandlerInterface $handler
     * @return LoanApplicationHandlerInterface
     */
    public function setNext(LoanApplicationHandlerInterface $handler): LoanApplicationHandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    /**
     * @param LoanApplication $application
     * @return LoanApplication
     */
    public function handle(LoanApplication $application): LoanApplication
    {
        if ($application->getStatus() === LoanApplication::REJECT_STATUS) {
            return $application;
        }

        if ($this->canHandle($application)) {
            $application = $this->process($application);
        }

        if ($this->nextHandler) {
            return $this->nextHandler->handle($application);
        }

        return $application;
    }

    /**
     * @param LoanApplication $application
     * @return bool
     */
    abstract protected function canHandle(LoanApplication $application): bool;

    /**
     * @param LoanApplication $application
     * @return LoanApplication
     */
    protected function process(LoanApplication $application): LoanApplication
    {
        return $application;
    }
}
