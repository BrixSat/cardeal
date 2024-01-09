<?php

declare(strict_types=1);

use App\Domain\Client\ClientRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\SqlUserRepository;
use App\Infrastructure\Persistence\Client\SqlClientRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder)
{
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions(
        [
            //UserRepository::class => autowire(InMemoryUserRepository::class),
            UserRepository::class => autowire(SqlUserRepository::class),
            ClientRepository::class => autowire(SqlClientRepository::class),
        ]
    );
};
