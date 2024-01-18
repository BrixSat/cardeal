<?php

namespace App\Infrastructure\Persistence;

use PDO;
use PDOException;
use Psr\Log\LoggerInterface;

class DatabaseConnection
{
    protected ?PDO $conn;

    /**
     * PgConnection constructor.
     *
     * @param LoggerInterface $logger
     */
    function __construct (private readonly LoggerInterface $logger)
    {
        $conn_string = sprintf(
            "mysql:host=%s;port=%d;dbname=%s",
            DATABASE_HOST,
            DATABASE_PORT,
            DATABASE_NAME
        );

        try
        {
            $this->conn = new PDO($conn_string, DATABASE_USER, DATABASE_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception)
        {
            $this->logger->error($exception->getMessage());
            throw $exception;
        }
    }

    public function run(string $query, $params = [], $mode = PDO::FETCH_ASSOC): array|false
    {
        $this->logger->debug("Run query: " . $query, [ 'args' => $params, 'mode' => $mode ]);

        $stmt = $this->conn->prepare($query);

        $stmt->execute($params);

        $results = $stmt->fetchAll($mode);
        $stmt->closeCursor();

        return $results;
    }

    public function insert (string $query, $params = []): false|string
    {
        $this->logger->debug("Run insert query: " . $query, [ 'args' => $params ]);

        $stmt = $this->conn->prepare($query);

        $stmt->execute($params);
        $stmt->closeCursor();

        return $this->conn->lastInsertId();
    }

    public function update (string $query, $params = []): false|string
    {
        $this->logger->debug("Run update query: " . $query, [ 'args' => $params ]);

        $stmt = $this->conn->prepare($query);

        $stmt->execute($params);
        $stmt->closeCursor();

        return $this->conn->lastInsertId();
    }
}
