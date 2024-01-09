<?php

declare(strict_types=1);

namespace App\Domain\Client;

interface ClientRepository
{
    /**
     * @return Client[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function findById(int $id): Client;

    /**
     * @param string $name
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function findByName(string $name): Client;

    /**
     * @param string $email
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function findByEmail(string $email): Client;

    public function add(Client $client): bool;

    public function delete(int $clientId):bool;

}
