<?php

namespace App\Clients\Domain\Factory;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Entity\Address;
use App\Clients\Domain\Entity\CreditInfo;
use App\Clients\Domain\ValueObject\ClientFirstName;
use App\Clients\Domain\ValueObject\ClientLastName;
use App\Clients\Domain\ValueObject\ClientAge;
use App\Clients\Domain\ValueObject\ClientAddress;
use App\Clients\Domain\ValueObject\ClientCreditInfoFICOScore;
use App\Clients\Domain\ValueObject\ClientCreditInfoIncome;
use App\Clients\Domain\ValueObject\ClientCreditInfoSSN;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\PhoneNumber;
use App\Clients\Domain\Service\UlidGeneratorInterface;

readonly class ClientFactory
{
    /**
     * @param UlidGeneratorInterface $ulidGenerator
     */
    public function __construct(private UlidGeneratorInterface $ulidGenerator)
    {
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param int $age
     * @param string $city
     * @param string $state
     * @param string $zip
     * @param int $ficoScore
     * @param float $income
     * @param string $ssn
     * @param string $email
     * @param string $phoneNumber
     * @return Client
     */
    public function create(
        string $firstName,
        string $lastName,
        int $age,
        string $city,
        string $state,
        string $zip,
        int $ficoScore,
        float $income,
        string $ssn,
        string $email,
        string $phoneNumber
    ): Client {
        $clientFirstName = new ClientFirstName($firstName);
        $clientLastName = new ClientLastName($lastName);
        $clientAge = new ClientAge($age);
        $clientAddress = new ClientAddress($city, $state, $zip);
        $clientEmail = new Email($email);
        $clientPhoneNumber = new PhoneNumber($phoneNumber);

        $address = new Address($this->ulidGenerator, $clientAddress);

        $creditInfoFICOScore = new ClientCreditInfoFICOScore($ficoScore);
        $creditInfoIncome = new ClientCreditInfoIncome($income);
        $creditInfoSSN = new ClientCreditInfoSSN($ssn);
        $creditInfo = new CreditInfo($this->ulidGenerator, $creditInfoFICOScore, $creditInfoSSN, $creditInfoIncome);

        return new Client(
            $this->ulidGenerator,
            $clientFirstName,
            $clientLastName,
            $clientAge,
            $address,
            $creditInfo,
            $clientEmail,
            $clientPhoneNumber
        );
    }
}
