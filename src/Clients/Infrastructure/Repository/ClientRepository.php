<?php

namespace App\Clients\Infrastructure\Repository;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Repository\ClientRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    /** @psalm-suppress PossiblyUnusedParam */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * @param string $ulid
     * @return Client|null
     */
    public function findByUlid(string $ulid): ?Client
    {
        return $this->findOneBy(['ulid' => $ulid]);
    }

    /**
     * @param Client $client
     * @return void
     */
    public function save(Client $client): void
    {
        $this->getEntityManager()->persist($client);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Client $client
     * @return void
     */
    public function delete(Client $client): void
    {
        $this->getEntityManager()->remove($client);
        $this->getEntityManager()->flush();
    }
}
