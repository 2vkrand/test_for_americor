<?php

namespace App\LoanApplication\Infrastructure\Adapter;

use App\Clients\Application\Service\GetClientService;
use App\LoanApplication\Domain\DTO\ClientInfoDTO;

class ClientAdapter
{
    /**
     * @var GetClientService
     */
    private GetClientService $getClientService;

    /**
     * @param GetClientService $getClientService
     */
    public function __construct(GetClientService $getClientService)
    {
        $this->getClientService = $getClientService;
    }

    /**
     * @param string $clientUlid
     * @return ClientInfoDTO
     */
    public function getClientInfo(string $clientUlid): ClientInfoDTO
    {
        $client = $this->getClientService->execute($clientUlid);

        return new ClientInfoDTO(
            $client->getAge(),
            $client->getCreditInfo()->getIncome(),
            $client->getCreditInfo()->getFICOScore(),
            $client->getAddress()->getState(),
            $client->getEmail(),
            $client->getPhoneNumber()
        );
    }
}
