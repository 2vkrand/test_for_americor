<?php

namespace App\LoanApplication\Application\Service;

use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Domain\Event\LoanApproved;
use App\LoanApplication\Domain\Event\LoanRejected;
use App\LoanApplication\Domain\Service\LoanStatusServiceInterface;
use App\Shared\Domain\Event\EventDispatcherInterface;

class LoanStatusService implements LoanStatusServiceInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param LoanApplication $loanApplication
     * @return LoanApplication
     */
    public function approve(LoanApplication $loanApplication): LoanApplication
    {
        $loanApplication->approve();
        $this->eventDispatcher->dispatch(new LoanApproved($loanApplication->getClientInfo()));

        return $loanApplication;
    }

    /**
     * @param LoanApplication $loanApplication
     * @return LoanApplication
     */
    public function reject(LoanApplication $loanApplication): LoanApplication
    {
        $loanApplication->reject();
        $this->eventDispatcher->dispatch(new LoanRejected($loanApplication->getClientInfo()));

        return $loanApplication;
    }
}

