<?php

declare(strict_types=1);

use App\Infrastructure\Persistence\DatabaseConnection;
use App\Infrastructure\Slim\Handlers\HttpErrorHandler;
use App\Infrastructure\Twig\Extension\BasePathExtension;
use App\Infrastructure\Twig\Extension\CsrfExtension;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Interfaces\RouteParserInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(
    [
        LoggerInterface::class => function () {

            $loggerSettings = LOGGER_INTERNAL_CONFIGS;
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        ErrorHandlerInterface::class => fn(App $app, LoggerInterface $logger, RouteParserInterface $router)
            => new HttpErrorHandler($app->getCallableResolver(), $app->getResponseFactory(), $router, $logger),

        Guard::class => function (App $app, LoggerInterface $logger)
        {
            $guard = new Guard($app->getResponseFactory(), persistentTokenMode: true);
            $guard->setFailureHandler(function () use ($logger, $app)
            {
                $logger->warning("Invalid csrf token");
                return $app->getResponseFactory()->createResponse(400);
            });

            return $guard;
        },


        // Configure Twig
        Environment::class => function (Guard $guard, App $app) {
            $loader = new FilesystemLoader(__DIR__ . '/../src/View');
            $twig = new Environment($loader, [ 'debug' => true]);
            $twig->addGlobal('project_owner_url', PROJECT_OWNER_URL);
            $twig->addGlobal('project_owner_name', PROJECT_OWNER_NAME);
            $twig->addGlobal('app_name', APP_NAME);
            $twig->addGlobal('app_description', APP_DESCRIPTION);
            $twig->addGlobal('app_version', VERSION_APP);
            $twig->addGlobal('date_version', VERSION_DATE);
            $twig->addExtension(new CsrfExtension($guard));
            $twig->addExtension(new BasePathExtension($app->getBasePath()));
            $twig->addExtension(new DebugExtension());
            return $twig;
        },

        DatabaseConnection::class => fn(LoggerInterface $logger) => new DatabaseConnection($logger),

        RouteParserInterface::class => fn(App $app) => $app->getRouteCollector()->getRouteParser()
    ]);

return $containerBuilder;
