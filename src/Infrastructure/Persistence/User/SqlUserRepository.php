<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\DomainException\InvalidArgumentException;
use App\Infrastructure\Persistence\DatabaseConnection;
use Exception;

readonly class SqlUserRepository
{

    /**
     * @param DatabaseConnection $db
     */
    public function __construct(private DatabaseConnection $db) { }

    /**
     * @param User $user
     *
     * @return User
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function add(User $user): User
    {
        $result = $this->db->insert(
            "INSERT INTO user(
                        username, firstName, lastName, email, password, jobTitle
                    ) VALUES (?,?,?,?,?,?);",
            [
                $user->getUsername(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->email,
                $user->password,
                $user->jobTitle
            ]);

        if ($result === false) throw new InvalidArgumentException('user',"Failed to insert user");

        $user->id = (int)$result;

        return $user;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function findAll(): array
    {
        $result = $this->db->run("SELECT * FROM user;");

        foreach ($result as $index => $line) {
            $result[$index] = self::entityToObject($line);
        }

        return $result;
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function findById(int $id): User
    {
        $result = $this->db->run("SELECT * FROM user WHERE id = ?;", [$id]);

        if ($result === false || !isset($result[0])) throw new UserNotFoundException();

        return self::entityToObject($result[0]);
    }

    /**
     * @param string $username
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(string $username): User
    {
        $result = $this->db->run("SELECT * FROM user WHERE username = ? limit 1;", [$username]);

        if (!isset($result[0])) throw new UserNotFoundException();

        return self::entityToObject($result[0]);
    }

    /**
     * @param string $email
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function findByEmail(string $email): User
    {
        $result = $this->db->run("SELECT * FROM user where email = ? limit 1;", [$email]);

        if (!isset($result[0])) throw new UserNotFoundException();

        return self::entityToObject($result[0]);
    }

    /**
     * @param User   $user
     * @param string $newHash
     *
     * @return bool
     * @throws Exception
     */
    public function updateUserPassword(User $user, string $newHash): bool
    {
        $result = $this->db->run("update user set password = ? WHERE id = ?;", [$newHash, $user->id]);

        if ($result === false) return false;

        return true;
    }

    /**
     * @param User   $user
     * @param string $newHash
     *
     * @return bool
     * @throws Exception
     */
    public function updateUserRecoverPassword(User $user, string $newHash): bool
    {
        $result = $this->db->run(
            "update user set recoverPassword = ?, password = '' where id = ?;",
            [
                $newHash,
                $user->id
            ]
        );

        if (!isset($result[0])) return false;

        return true;
    }

    /**
     * @param int $userId
     *
     * @return bool
     * @throws Exception
     */
    public function delete(int $userId): bool
    {
        if($userId == 1) return false;
        $result = $this->db->run("DELETE FROM user WHERE id = ?;", [$userId]);

        return $result !== false;
    }

    /**
     * This functions converts data base entity in to class object.
     *
     * @throws Exception
     */
    private static function entityToObject ($entity): User
    {
        return new User(
            $entity['id'],
            $entity['username'],
            $entity['firstName'],
            $entity['lastName'],
            $entity['password'],
            $entity['recoverPassword'],
            $entity['email'],
            $entity['jobTitle'],
            new \DateTime($entity['created_at']),
            new \DateTime($entity['updated_at']),
        );
    }

}
