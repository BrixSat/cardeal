<?php

namespace App\Infrastructure\Persistence;

use DateTime;
use Exception;
use PDO;
use PDOException;
use PDOStatement;
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

    /**
     * @throws Exception
     */
    public function run(string $query, $params = [], $mode = PDO::FETCH_ASSOC): array|false
    {
        $this->logger->debug("query mode run", [
            'query' => $query,
            'args'  => $params,
            'mode'  => $mode,
        ]);

        $stmt = $this->prepare($query, $params);

        $stmt->execute();

        $results = $stmt->fetchAll($mode);
        $stmt->closeCursor();

        return $results;
    }

    /**
     * @throws Exception
     */
    public function insert (string $query, $params = []): false|string
    {
        $this->logger->debug("query mode insert", [
            'query' => $query,
            'args'  => $params
        ]);

        $stmt = $this->prepare($query, $params);

        $stmt->execute();
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

    /**
     * @param string $query
     * @param array  $params
     *
     * @return false|PDOStatement
     * @throws Exception
     */
    private function prepare (string $query, array $params = []): false|PDOStatement
    {
        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $element)
        {
            $this->logger->debug("bindParam", [
                'key' => $key,
                'element' => $element,
                'type' => gettype($element)
            ]);

            switch (gettype($element))
            {
                case 'integer':
                    $added = $stmt->bindParam(gettype($key) == 'integer' ? $key + 1 : $key, $params[$key], PDO::PARAM_INT);
                    break;
                case 'boolean':
                    $added = $stmt->bindParam(gettype($key) == 'integer' ? $key + 1 : $key, $params[$key], PDO::PARAM_BOOL);
                    break;
                default:
                    if ($element instanceof DateTime)
                    {
                        $params[$key] = $element->format('Y-m-d\TH:i:s');
                    }

                    $added = $stmt->bindParam(gettype($key) == 'integer' ? $key + 1 : $key, $params[$key]);
            }

            if (!$added)
            {
                throw new Exception("Failed to add");
            }
        }

        return $stmt;
    }
}
