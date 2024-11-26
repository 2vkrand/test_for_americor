<?php

namespace App\Clients\Domain\Repository;

use App\Clients\Domain\Entity\Client;

interface ClientRepositoryInterface
{
    /**
     * @param string $ulid
     * @return Client|null
     */
    public function findByUlid(string $ulid): ?Client;

    /**
     * @param Client $client
     * @return void
     */
    public function save(Client $client): void;

    /**
     * @param Client $client
     * @return void
     */
    public function delete(Client $client): void;
}
