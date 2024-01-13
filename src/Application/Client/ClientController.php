<?php
namespace App\Application\Client;

use App\Domain\Client\ClientNotFoundException;
use App\Domain\Client\ClientRepository;
use App\Domain\Client\Client;
use App\Infrastructure\Slim\HttpResponse;
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
use function PHPUnit\Framework\isNull;

class ClientController
{
    use HttpResponse;

    public function __construct(public LoggerInterface $logger, public ClientRepository $clientRepository) { }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function viewAddClientForm(Request $request, Response $response, Environment $twig): Response|Message
    {
        $response->getBody()->write($twig->render('pages/clients/add.twig', []));
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function viewClientsList(Request $request, Response $response, Environment $twig): Response|Message
    {
        $userList = $this->clientRepository->findAll();

        $response->getBody()->write($twig->render('pages/admin/list-users.twig', ["userList" => $userList]));
        return $response->withHeader('Content-Type', 'text/html');
    }


    /**
     * @throws \Exception
     */
    public function addClient(Request              $request,
                              Response             $response,
                              RouteParserInterface $router): Response|Message
    {

        $groomEmail = $request->getParsedBody()['groomEmail'];

        if (isset( $request->getParsedBody()['lights'])) { $lights=1; } else { $lights = 0;}
        if (isset( $request->getParsedBody()['rooms'])) { $rooms= 1; } else { $rooms = 0;}
        if (isset( $request->getParsedBody()['menu'])) { $menu = 1; } else { $menu = 0;}
        if (isset( $request->getParsedBody()['fireworks'])) { $fireworks= 1; } else { $fireworks = 0;}

        try {
            $this->clientRepository->findByEmail($groomEmail);
            throw new InvalidArgumentException("Client Already exist");
        } catch (ClientNotFoundException) { }


        $this->clientRepository->add(
            new Client(
                id              : -1,
                groomName       : $request->getParsedBody()['groomName'],
                brideName       : $request->getParsedBody()['brideName'],
                groomBirthDate  : new \DateTime($request->getParsedBody()['groomBirthDate']),
                brideBirthDate  : new \DateTime($request->getParsedBody()['brideBirthDate']),
                groomEmail      : $groomEmail,
                brideEmail      : $request->getParsedBody()['brideEmail'],
                groomPhone      : $request->getParsedBody()['groomPhone'],
                bridePhone      : $request->getParsedBody()['bridePhone'],
                groomAddress    : $request->getParsedBody()['groomAddress'],
                brideAddress    : $request->getParsedBody()['brideAddress'],
                typeOfEvent     : $request->getParsedBody()['typeOfEvent'],
                civilOrChurch   : $request->getParsedBody()['civilOrChurch'],
                eventDate       : new \DateTime($request->getParsedBody()['eventDate']),
                alternativeDates: $request->getParsedBody()['alternativeDates'],
                closedDate      : new \DateTime($request->getParsedBody()['closedDate']),
                tastingDate     : new \DateTime( $request->getParsedBody()['tastingDate']),
                nif             : $request->getParsedBody()['nif'],
                signalAmount    : $request->getParsedBody()[ 'signalAmmount'],
                lights          : $lights,
                rooms           : $rooms,
                menu            : $menu,
                fireworks       : $fireworks,
                fireType        : $request->getParsedBody()['fireType'] ?? '',
                observations    : $request->getParsedBody()['observations']
            )
        );

        $this->logger->info("New user added", []);

        return $response->withStatus(301)->withHeader('Location', $router->urlFor('viewClientsList'));
    }

}

