<?php

namespace App\Clients\Application\Service;

use App\Clients\Application\Request\UpdateClientRequest;
use App\Clients\Domain\Repository\ClientRepositoryInterface;
use App\Clients\Domain\ValueObject\ClientAddress;
use App\Clients\Domain\ValueObject\ClientAge;
use App\Clients\Domain\ValueObject\ClientCreditInfoFICOScore;
use App\Clients\Domain\ValueObject\ClientCreditInfoIncome;
use App\Clients\Domain\ValueObject\ClientCreditInfoSSN;
use App\Clients\Domain\ValueObject\ClientFirstName;
use App\Clients\Domain\ValueObject\ClientLastName;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\PhoneNumber;

class UpdateClientService
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
     * @param UpdateClientRequest $request
     * @return void
     */
    public function execute(string $ulid, UpdateClientRequest $request): void
    {
        $client = $this->clientRepository->findByUlid($ulid);

        if (!$client) {
            throw new \InvalidArgumentException('Client not found');
        }

        $client->changeFirstName(new ClientFirstName($request->firstName));
        $client->changeLastName(new ClientLastName($request->lastName));
        $client->changeAge(new ClientAge($request->age));
        $client->changeAddress($client->getAddress()->changeAddress(
            new ClientAddress($request->city, $request->state, $request->zip)
        ));
        $client->getCreditInfo()->changeFICOScore(new ClientCreditInfoFICOScore($request->ficoScore));
        $client->getCreditInfo()->changeSSN(new ClientCreditInfoSSN($request->ssn));
        $client->getCreditInfo()->changeIncome(new ClientCreditInfoIncome($request->income));
        $client->changeEmail(new Email($request->email));
        $client->changePhoneNumber(new PhoneNumber($request->phoneNumber));

        $this->clientRepository->save($client);
    }
}
