<?php

namespace App\Clients\Application\Service;

use App\Clients\Application\Request\CreateClientRequest;
use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Factory\ClientFactory;
use App\Clients\Domain\Repository\ClientRepositoryInterface;

class CreateClientService
{
    /**
     * @var ClientFactory
     */
    private ClientFactory $clientFactory;
    /**
     * @var ClientRepositoryInterface
     */
    private ClientRepositoryInterface $clientRepository;

    /**
     * @param ClientFactory $clientFactory
     * @param ClientRepositoryInterface $clientRepository
     */
    public function __construct(ClientFactory $clientFactory, ClientRepositoryInterface $clientRepository)
    {
        $this->clientFactory = $clientFactory;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param CreateClientRequest $request
     * @return Client
     */
    public function execute(CreateClientRequest $request): Client
    {
        $client = $this->clientFactory->create(
            $request->firstName,
            $request->lastName,
            $request->age,
            $request->city,
            $request->state,
            $request->zip,
            $request->ficoScore,
            $request->income,
            $request->ssn,
            $request->email,
            $request->phoneNumber
        );

        $this->clientRepository->save($client);

        return $client;
    }
}
