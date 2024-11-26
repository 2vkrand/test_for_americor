<?php

namespace App\Clients\Application\Service;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Repository\ClientRepositoryInterface;

class GetClientService
{
    /**
     * @var ClientRepositoryInterface
     */
    private ClientRepositoryInterface $clientRepository;

    /**
     * @param ClientRepositoryInterface $clientRepository
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param string $ulid
     * @return Client
     */
    public function execute(string $ulid): Client
    {
        $client = $this->clientRepository->findByUlid($ulid);

        if (!$client) {
            throw new \InvalidArgumentException('Client not found');
        }

        return $client;
    }
}
