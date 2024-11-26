<?php

namespace App\Clients\Domain\ValueObject;

readonly class ClientAddress
{
    /**
     * @param string $city
     * @param string $state
     * @param string $zip
     */
    public function __construct(
        private string $city,
        private string $state,
        private string $zip
    ) {
        //TODO: Реализовать проверку города, штата и zip.
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
}
