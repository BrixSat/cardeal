<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Client;

use App\Domain\Client\Client;
use App\Domain\Client\ClientNotFoundException;
use App\Infrastructure\Persistence\DatabaseConnection;
use DateTime;
use Exception;

readonly class SqlClientRepository
{
    public function __construct(private DatabaseConnection $db) { }

    /**
     * @param Client $client
     *
     * @return bool
     * @throws Exception
     */
    public function add(Client $client): bool
    {
        $id = $this->db->insert(
            "INSERT INTO clients(
                    groomName,
                    brideName,
                    groomBirthDate,
                    brideBirthDate,
                    groomEmail,
                    brideEmail,
                    groomPhone,
                    bridePhone,
                    groomAddress,
                    brideAddress,
                    typeOfEvent,
                    civilOrChurch,
                    eventDate,
                    alternativeDates,
                    closedDate,
                    tastingDate,
                    nif,
                    signalAmmount,
                    lights,
                    rooms,
                    menu,
                    fireworks,
                    fireType,
                    observations
            ) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);",
            [
                $client->getGroomName(),
                $client->getBrideName(),
                $client->getGroomBirthDate(),
                $client->getBrideBirthDate(),
                $client->getGroomEmail(),
                $client->getBrideEmail(),
                $client->getGroomPhone(),
                $client->getBridePhone(),
                $client->getGroomAddress(),
                $client->getBrideAddress(),
                $client->getTypeOfEvent(),
                $client->getCivilOrChurch(),
                $client->getEventDate(),
                $client->getAlternativeDates(),
                $client->getClosedDate(),
                $client->getTastingDate(),
                $client->getNif(),
                $client->getSignalAmount(),
                $client->getLights(),
                $client->getRooms(),
                $client->getMenu(),
                $client->getFireworks(),
                $client->getFireType(),
                $client->getObservations(),
            ]);

        return $id !== false;
    }

    public function update(Client $client): bool
    {
        $id = $this->db->insert(
            "update clients SET
                    groomName = ? ,
                    brideName = ? ,
                    groomBirthDate = ? ,
                    brideBirthDate = ? ,
                    groomEmail = ? ,
                    brideEmail = ? ,
                    groomPhone = ? ,
                    bridePhone = ? ,
                    groomAddress = ? ,
                    brideAddress = ? ,
                    typeOfEvent = ? ,
                    civilOrChurch = ? ,
                    eventDate = ? ,
                    alternativeDates = ? ,
                    closedDate = ? ,
                    tastingDate = ? ,
                    nif = ? ,
                    signalAmmount = ? ,
                    lights = ? ,
                    rooms = ? ,
                    menu = ? ,
                    fireworks = ? ,
                    fireType = ? ,
                    observations = ? 
                WHERE id = ? ;",
            [
                $client->getGroomName(),
                $client->getBrideName(),
                $client->getGroomBirthDate(),
                $client->getBrideBirthDate(),
                $client->getGroomEmail(),
                $client->getBrideEmail(),
                $client->getGroomPhone(),
                $client->getBridePhone(),
                $client->getGroomAddress(),
                $client->getBrideAddress(),
                $client->getTypeOfEvent(),
                $client->getCivilOrChurch(),
                $client->getEventDate(),
                $client->getAlternativeDates(),
                $client->getClosedDate(),
                $client->getTastingDate(),
                $client->getNif(),
                $client->getSignalAmount(),
                $client->getLights(),
                $client->getRooms(),
                $client->getMenu(),
                $client->getFireworks(),
                $client->getFireType(),
                $client->getObservations(),
                $client->id
            ]);

        return $id !== false;
    }


    /**
     * @return array
     * @throws Exception
     */
    public function findAll(): array
    {
        $result = $this->db->run("SELECT * FROM clients;");

        foreach ($result as $index => $line) {
            $result[$index] = self::fromDBtoClient($line);
        }
        return $result;
    }

    /**
     * @param int $id
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function findById(int $id): Client
    {
        $result = $this->db->run("SELECT * FROM clients WHERE id = ?;", [$id]);

        if (!isset($result[0])) {
            throw new ClientNotFoundException();
        }

        return self::fromDBtoClient($result[0]);
    }

    /**
     * @param string $name
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function findByName(string $name): Client
    {
        $result = $this->db->run("SELECT * FROM clients WHERE groomName = ? or brideName= ? limit 1;", [$name, $name]);

        if (!isset($result[0])) {
            throw new ClientNotFoundException();
        }

        return self::fromDBtoClient($result[0]);
    }

    /**
     * @param string $email
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function findByEmail(string $email): Client
    {
        $result = $this->db->run(
            "SELECT * FROM clients where groomEmail = ? or brideEmail= ? limit 1;", [$email, $email]
        );

        if (!isset($result[0])) {
            throw new ClientNotFoundException("Client not found with email $email");
        }

        return self::fromDBtoClient($result[0]);
    }

    public function delete(int $clientId): bool
    {
        if($clientId == 1) return false;
        $result = $this->db->run("DELETE FROM clients WHERE id = ?;", [$clientId]);
        return true;
    }

    /**
     * @param $line
     *
     * @return Client
     * @throws Exception
     */
    private static function fromDBtoClient($line): Client
    {
        return new Client(
            $line['id'],
            $line['groomName'],
            $line['brideName'],
            new DateTime($line['groomBirthDate']),
            new DateTime($line['brideBirthDate']),
            $line['groomEmail'],
            $line['brideEmail'],
            $line['groomPhone'],
            $line['bridePhone'],
            $line['groomAddress'],
            $line['brideAddress'],
            $line['typeOfEvent'],
            $line['civilOrChurch'],
            new DateTime($line['eventDate']),
            $line['alternativeDates'],
            new DateTime($line['closedDate']),
            new DateTime($line['tastingDate']),
            $line['nif'],
            $line['signalAmmount'],
            $line['lights'],
            $line['rooms'],
            $line['menu'],
            $line['fireworks'],
            $line['fireType'],
            $line['observations'],
            new DateTime($line['createdAt']),
            new DateTime($line['updatedAt'])
        );
    }

}
