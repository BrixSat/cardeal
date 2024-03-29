<?php

declare(strict_types=1);

namespace App\Infrastructure\Slim\Handlers;

use App\Application\ActionError;
use App\Application\ActionPayload;
use App\Infrastructure\DomainException\DomainException;
use App\Infrastructure\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\RouteParserInterface;
use Throwable;

class HttpErrorHandler extends ErrorHandler
{
    public function __construct(
        CallableResolverInterface             $callableResolver,
        ResponseFactoryInterface              $responseFactory,
        private readonly RouteParserInterface $router,
        ?LoggerInterface                      $logger = null,
    )
    {
        parent::__construct($callableResolver, $responseFactory, $logger);
        $this->logger->debug(self::class . " :: __construct");
    }

    protected function respond(): Response
    {
        $exception = $this->exception;

        $this->logger->warning("Unhandled error",['exceptionMessage'=>$exception->getMessage()]);

        $statusCode = 500;
        $error = new ActionError(
            ActionError::SERVER_ERROR,
            'An internal error has occurred while processing your request.'
        );

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
            $error->setDescription($exception->getMessage());

            if ($exception instanceof HttpNotFoundException) {
                $error->setType(ActionError::RESOURCE_NOT_FOUND);
            } elseif ($exception instanceof HttpMethodNotAllowedException) {
                $error->setType(ActionError::NOT_ALLOWED);
            } elseif ($exception instanceof HttpUnauthorizedException) {
                $error->setType(ActionError::UNAUTHENTICATED);
            } elseif ($exception instanceof HttpForbiddenException) {
                $error->setType(ActionError::INSUFFICIENT_PRIVILEGES);
            } elseif ($exception instanceof HttpBadRequestException) {
                $error->setType(ActionError::BAD_REQUEST);
            } elseif ($exception instanceof HttpNotImplementedException) {
                $error->setType(ActionError::NOT_IMPLEMENTED);
            }
        }

        if ($exception instanceof DomainException)
        {
            $statusCode = $exception->getCode();
            $error->setDescription($exception->getMessage());

            if ($exception instanceof DomainRecordNotFoundException ) {
                $error->setType(ActionError::RESOURCE_NOT_FOUND);
            }

            $payload = new ActionPayload($statusCode, null, $error);
            $encodedPayload = json_encode($payload, JSON_PRETTY_PRINT);

            $response = $this->responseFactory->createResponse($statusCode);
            $response->getBody()->write($encodedPayload);

            return $response->withHeader('Content-Type', 'application/json');
        }

        if (!$this->displayErrorDetails) {
            $response = $this->responseFactory->createResponse(303);
            if ($statusCode >= 500) {
                return $response->withHeader('Location', $this->router->urlFor('500'));
            } else {
                return $response->withHeader('Location', $this->router->urlFor('404'));
            }
        }

        if (
            !($exception instanceof HttpException)
            && $exception instanceof Throwable
            && $this->displayErrorDetails
        ) {
            $error->setDescription($exception->getMessage());
        }

        $payload = new ActionPayload($statusCode, null, $error);
        $encodedPayload = json_encode($payload, JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write($encodedPayload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
