<?php

namespace App\Clients\Infrastructure\Controller;

use App\Clients\Application\Request\UpdateClientRequest;
use App\Clients\Application\Service\CreateClientService;
use App\Clients\Application\Request\CreateClientRequest;
use App\Clients\Application\Service\GetClientService;
use App\Clients\Application\Service\UpdateClientService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

readonly class ClientController
{
    /**
     * @param CreateClientService $createClientService
     * @param UpdateClientService $updateClientService
     * @param GetClientService $getClientService
     */
    public function __construct(
        private CreateClientService $createClientService,
        private UpdateClientService $updateClientService,
        private GetClientService $getClientService,
    ) {
    }

    /**
     * @param string $ulid
     * @return Response
     */
    #[Route('/clients/{ulid}', name: 'clients_get', methods: ['GET'])]
    public function getClient(string $ulid): Response
    {
        try {
            $client = $this->getClientService->execute($ulid);

            return new JsonResponse([
                'ulid' => $client->getUlid(),
                'firstName' => $client->getFirstName(),
                'lastName' => $client->getLastName(),
                'age' => $client->getAge(),
                'city' => $client->getAddress()->getCity(),
                'state' => $client->getAddress()->getState(),
                'zip' => $client->getAddress()->getZip(),
                'ficoScore' => $client->getCreditInfo()->getFICOScore(),
                'income' => $client->getCreditInfo()->getIncome(),
                'ssn' => $client->getCreditInfo()->getSSN(),
                'email' => $client->getEmail(),
                'phoneNumber' => $client->getPhoneNumber()
            ], Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/clients', name: 'clients_create', methods: ['POST'])]
    public function createClient(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $createClientRequest = new CreateClientRequest($data);
            $client = $this->createClientService->execute($createClientRequest);

            return new JsonResponse([
                'ulid' => $client->getUlid(),
                'firstName' => $client->getFirstName(),
                'lastName' => $client->getLastName(),
                'age' => $client->getAge(),
                'email' => $client->getEmail(),
                'phoneNumber' => $client->getPhoneNumber()
            ], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string $ulid
     * @param Request $request
     * @return Response
     */
    #[Route('/clients/{ulid}', name: 'clients_update', methods: ['PUT'])]
    public function updateClient(string $ulid, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $updateClientRequest = new UpdateClientRequest($data);
            $this->updateClientService->execute($ulid, $updateClientRequest);

            return new JsonResponse(['status' => 'Client updated'], Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
