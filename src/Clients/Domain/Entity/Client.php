<?php

namespace App\Clients\Domain\Entity;

use App\Clients\Domain\Service\UlidGeneratorInterface;
use App\Clients\Domain\ValueObject\ClientAge;
use App\Clients\Domain\ValueObject\ClientFirstName;
use App\Clients\Domain\ValueObject\ClientLastName;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\PhoneNumber;
use App\Shared\Domain\ValueObject\Ulid;

class Client
{
    /**
     * @var Ulid
     */
    private readonly Ulid $ulid;

    /**
     * @param UlidGeneratorInterface $ulidGenerator
     * @param ClientFirstName $firstName
     * @param ClientLastName $lastName
     * @param ClientAge $age
     * @param Address $address
     * @param CreditInfo $creditInfo
     * @param Email $email
     * @param PhoneNumber $phoneNumber
     */
    public function __construct(
        UlidGeneratorInterface $ulidGenerator,
        private ClientFirstName $firstName,
        private ClientLastName $lastName,
        private ClientAge $age,
        private Address $address,
        private CreditInfo $creditInfo,
        private Email $email,
        private PhoneNumber $phoneNumber
    ) {
        $this->ulid = new Ulid($ulidGenerator->generate());
    }

    /**
     * @return string
     */
    public function getUlid(): string
    {
        return $this->ulid->getValue();
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName->getValue();
    }

    /**
     * @param ClientFirstName $firstName
     * @return Client
     */
    public function changeFirstName(ClientFirstName $firstName): Client
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName->getValue();
    }

    /**
     * @param ClientLastName $lastName
     * @return Client
     */
    public function changeLastName(ClientLastName $lastName): Client
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age->getValue();
    }

    /**
     * @param ClientAge $age
     * @return Client
     */
    public function changeAge(ClientAge $age): Client
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Client
     */
    public function changeAddress(Address $address): Client
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return CreditInfo
     */
    public function getCreditInfo(): CreditInfo
    {
        return $this->creditInfo;
    }

    /**
     * @param CreditInfo $creditInfo
     * @return Client
     */
    public function changeCreditInfo(CreditInfo $creditInfo): Client
    {
        $this->creditInfo = $creditInfo;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    /**
     * @param Email $email
     * @return Client
     */
    public function changeEmail(Email $email): Client
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber->getValue();
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return Client
     */
    public function changePhoneNumber(PhoneNumber $phoneNumber): Client
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
}
