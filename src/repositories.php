<?php

declare(strict_types=1);

use App\Infrastructure\Persistence\User\SqlUserRepository;
use App\Infrastructure\Persistence\Client\SqlClientRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder)
{
    $containerBuilder->addDefinitions(
        [
            SqlUserRepository::class => autowire(SqlUserRepository::class),
            SqlClientRepository::class => autowire(SqlClientRepository::class),
        ]
    );
};
