<?php

namespace App\Clients\Domain\Entity;

use App\Clients\Domain\Service\UlidGeneratorInterface;
use App\Clients\Domain\ValueObject\ClientAddress;
use App\Shared\Domain\ValueObject\Ulid;

class Address
{
    /**
     * @var Ulid
     */
    readonly Ulid $ulid;

    /**
     * @var string
     */
    private string $city;

    /**
     * @var string
     */
    private string $state;

    /**
     * @var string
     */
    private string $zip;

    /**
     * @param UlidGeneratorInterface $ulidGenerator
     * @param ClientAddress $address
     */
    public function __construct(
        UlidGeneratorInterface $ulidGenerator,
        ClientAddress $address,
    ) {
        $this->ulid = new Ulid($ulidGenerator->generate());
        $this->city = $address->getCity();
        $this->state = $address->getState();
        $this->zip = $address->getZip();
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
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param ClientAddress $address
     * @return $this
     */
    public function changeAddress(ClientAddress $address): Address
    {
        $this->city = $address->getCity();
        $this->state = $address->getState();
        $this->zip = $address->getZip();

        return $this;
    }
}
