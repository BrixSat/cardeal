<?php
namespace App\Application\Client;

use App\Domain\Client\ClientNotFoundException;
use App\Domain\Client\Client;
use App\Infrastructure\Persistence\Client\SqlClientRepository;
use App\Infrastructure\Slim\HttpResponse;
use Exception;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Message;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ClientController
{
    use HttpResponse;

    public function __construct(public LoggerInterface $logger, public SqlClientRepository $clientRepository) { }

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Environment $twig
     *
     * @return Response|Message
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function viewAddClientForm(Request $request, Response $response, Environment $twig): Response|Message
    {
        $response->getBody()->write($twig->render('pages/clients/add.twig', []));
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Environment $twig
     *
     * @return Response|Message
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function viewClientsList(Request $request, Response $response, Environment $twig): Response|Message
    {
        $clientsList = $this->clientRepository->findAll();
        $response->getBody()->write($twig->render('pages/clients/list-clients.twig', ["clientsList" => $clientsList]));
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Environment $twig
     *
     * @return Response|Message
     * @throws ClientNotFoundException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function editClient(Request $request, Response $response, Environment $twig): Response|Message
    {
        $client = $this->clientRepository->findById((int) $request->getAttribute('id'));
        $response->getBody()->write($twig->render('pages/clients/edit.twig', ["client" => $client]));
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * @param Request     $request
     * @param Response    $response
     * @param Environment $twig
     *
     * @return Response|Message
     * @throws ClientNotFoundException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateClient(Request $request, Response $response, Environment $twig): Response|Message
    {
        $client = $this->clientRepository->findById((int) $request->getAttribute('id'));

        $this->clientRepository->update(
            Client::formToClient($request->getParsedBody(), $client->id)
        );

        $response->getBody()->write($twig->render('pages/clients/edit.twig', ["client" => $client]));
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * @param Request              $request
     * @param Response             $response
     * @param RouteParserInterface $router
     *
     * @return Response|Message
     * @throws Exception
     */
    public function addClient(Request              $request,
                              Response             $response,
                              RouteParserInterface $router): Response|Message
    {
        $groomEmail = $request->getParsedBody()['groomEmail'];

        try {
            $this->clientRepository->findByEmail($groomEmail);
//            $this->clientRepository->findByEmail($brideEmail);
            throw new InvalidArgumentException("Client Already exist");
        } catch (ClientNotFoundException) { }


        $this->clientRepository->add(
            Client::formToClient($request->getParsedBody())
        );

        $this->logger->info("New user added", []);

        return $response->withStatus(301)->withHeader('Location', $router->urlFor('viewClientsList'));
    }

}

