<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Client;

use App\Domain\Client\Client;
use App\Domain\Client\ClientNotFoundException;
use App\Domain\Client\ClientRepository;
use App\Infrastructure\Persistence\DatabaseConnection;
use Exception;

readonly class SqlClientRepository implements ClientRepository
{
    const dateformat = 'Y-m-d\TH:i:s';

    /**
     * @param DatabaseConnection $db
     */
    public function __construct(private DatabaseConnection $db) { }

    /**
     * @param Client $client
     *
     * @return true
     * @throws Exception
     */
    public function add(Client $client): bool
    {

        $result = $this->db->run(
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
                $client->getGroomBirthDate()->format(self::dateformat),
                $client->getBrideBirthDate()->format(self::dateformat),
                $client->getGroomEmail(),
                $client->getBrideEmail(),
                $client->getGroomPhone(),
                $client->getBridePhone(),
                $client->getGroomAddress(),
                $client->getBrideAddress(),
                $client->getTypeOfEvent(),
                $client->getCivilOrChurch(),
                $client->getEventDate()->format(self::dateformat),
                $client->getAlternativeDates(),
                $client->getClosedDate()->format(self::dateformat),
                $client->getTastingDate()->format(self::dateformat),
                $client->getNif(),
                $client->getSignalAmmount(),
                $client->getLights(),
                $client->getRooms(),
                $client->getMenu(),
                $client->getFireworks(),
                $client->getFireType(),
                $client->getObservations(),
            ]);

        return true;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function findAll(): array
    {
        $result = $this->db->run("SELECT * FROM clients;", []);

        foreach ($result as $index => $line) {
            $result[$index] = new Client(
                $line['id'],
                $line['groomName'],
                $line['brideName'],
                new \DateTime($line['groomBirthDate']),
                new \DateTime($line['brideBirthDate']),
                $line['groomEmail'],
                $line['brideEmail'],
                $line['groomPhone'],
                $line['bridePhone'],
                $line['groomAddress'],
                $line['brideAddress'],
                $line['typeOfEvent'],
                $line['civilOrChurch'],
                new \DateTime($line['eventDate']),
                $line['alternativeDates'],
                new \DateTime($line['closedDate']),
                new \DateTime($line['tastingDate']),
                $line['nif'],
                $line['signalAmmount'],
                $line['lights'],
                $line['rooms'],
                $line['menu'],
                $line['fireworks'],
                $line['fireType'],
                $line['observations'],
                new \DateTime($line['createdAt']),
                new \DateTime($line['updatedAt'])
            );
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function findById(int $id): Client
    {
        $result = $this->db->run("SELECT * FROM clients WHERE id = ?;", [$id]);

        if (!isset($result[0])) {
            throw new ClientNotFoundException();
        }

        return new Client(
            $result[0]['id'],
            $result[0]['groomName'],
            $result[0]['brideName'],
            new \DateTime($result[0]['groomBirthDate']),
            new \DateTime($result[0]['brideBirthDate']),
            $result[0]['groomEmail'],
            $result[0]['brideEmail'],
            $result[0]['groomPhone'],
            $result[0]['bridePhone'],
            $result[0]['groomAddress'],
            $result[0]['brideAddress'],
            $result[0]['typeOfEvent'],
            $result[0]['civilOrChurch'],
            new \DateTime($result[0]['eventDate']),
            $result[0]['alternativeDates'],
            new \DateTime($result[0]['closedDate']),
            new \DateTime($result[0]['tastingDate']),
            $result[0]['nif'],
            $result[0]['signalAmmount'],
            $result[0]['lights'],
            $result[0]['rooms'],
            $result[0]['menu'],
            $result[0]['fireworks'],
            $result[0]['fireType'],
            $result[0]['observations'],
            new \DateTime($result[0]['created_at']),
            new \DateTime($result[0]['updated_at'])
        );
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function findByName(string $name): Client
    {
        $result = $this->db->run("SELECT * FROM clients WHERE groomName = ? or brideName= ? limit 1;", [$name, $name]);

        if (!isset($result[0])) {
            throw new ClientNotFoundException();
        }

        return new Client(
            $result[0]['id'],
            $result[0]['groomName'],
            $result[0]['brideName'],
            new \DateTime($result[0]['groomBirthDate']),
            new \DateTime($result[0]['brideBirthDate']),
            $result[0]['groomEmail'],
            $result[0]['brideEmail'],
            $result[0]['groomPhone'],
            $result[0]['bridePhone'],
            $result[0]['groomAddress'],
            $result[0]['brideAddress'],
            $result[0]['typeOfEvent'],
            $result[0]['civilOrChurch'],
            new \DateTime($result[0]['eventDate']),
            $result[0]['alternativeDates'],
            new \DateTime($result[0]['closedDate']),
            new \DateTime($result[0]['tastingDate']),
            $result[0]['nif'],
            $result[0]['signalAmmount'],
            $result[0]['lights'],
            $result[0]['rooms'],
            $result[0]['menu'],
            $result[0]['fireworks'],
            $result[0]['fireType'],
            $result[0]['observations'],
            new \DateTime($result[0]['created_at']),
            new \DateTime($result[0]['updated_at'])
        );
    }

    public function findByEmail(string $email): Client
    {
        $result = $this->db->run(
            "SELECT * FROM clients where groomEmail = ? or brideEmail= ? limit 1;", [$email, $email]
        );

        if (!isset($result[0])) {
            throw new ClientNotFoundException("Client not found with email $email");
        }

        return new Client(
            $result[0]['id'],
            $result[0]['groomName'],
            $result[0]['brideName'],
            new \DateTime($result[0]['groomBirthDate']),
            new \DateTime($result[0]['brideBirthDate']),
            $result[0]['groomEmail'],
            $result[0]['brideEmail'],
            $result[0]['groomPhone'],
            $result[0]['bridePhone'],
            $result[0]['groomAddress'],
            $result[0]['brideAddress'],
            $result[0]['typeOfEvent'],
            $result[0]['civilOrChurch'],
            new \DateTime($result[0]['eventDate']),
            $result[0]['alternativeDates'],
            new \DateTime($result[0]['closedDate']),
            new \DateTime($result[0]['tastingDate']),
            $result[0]['nif'],
            $result[0]['signalAmmount'],
            $result[0]['lights'],
            $result[0]['rooms'],
            $result[0]['menu'],
            $result[0]['fireworks'],
            $result[0]['fireType'],
            $result[0]['observations'],
            new \DateTime($result[0]['created_at']),
            new \DateTime($result[0]['updated_at'])
        );
    }



    public function delete(int $clientId): bool
    {
        if($clientId == 1) return false;
        $result = $this->db->run("DELETE FROM clients WHERE id = ?;", [$clientId]);
        return true;
    }

}
