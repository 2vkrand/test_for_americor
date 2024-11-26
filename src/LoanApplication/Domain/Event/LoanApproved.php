<?php

namespace App\LoanApplication\Domain\Event;

use App\LoanApplication\Domain\DTO\ClientInfoDTO;

class LoanApproved extends AbstractDomainEvent
{
    /**
     * @var ClientInfoDTO
     */
    private ClientInfoDTO $clientInfo;

    /**
     * @param ClientInfoDTO $clientInfo
     */
    public function __construct(ClientInfoDTO $clientInfo)
    {
        parent::__construct();
        $this->clientInfo = $clientInfo;
    }

    /**
     * @return ClientInfoDTO
     */
    public function getClientInfo(): ClientInfoDTO
    {
        return $this->clientInfo;
    }
}