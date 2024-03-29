<?php

namespace App\Infrastructure\Slim;

use App\Application\ActionPayload;
use Slim\Psr7\Response;

trait HttpResponse
{
    /**
     * @param Response          $response
     * @param object|array|null $data
     * @param int               $statusCode
     *
     * @return Response
     */
    protected function respondWithData(Response     $response,
                                       object|array $data = null,
                                       int          $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($response, $payload);
    }

    /**
     * @param Response      $response
     * @param ActionPayload $payload
     *
     * @return Response
     */
    protected function respond(Response $response, ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->statusCode);
    }
}
