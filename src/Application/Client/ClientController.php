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


    public function addClient(Request            $request,
                            Response             $response,
                            Environment          $twig,
                            RouteParserInterface $router): Response|Message
    {
        $groomName = $request->getParsedBody()['groomName'];
        $groomBirthDate = new \DateTime($request->getParsedBody()['groomBirthdate']);
        $groomEmail = $request->getParsedBody()['groomEmail'];
        $groomPhone = $request->getParsedBody()['groomPhone'];
        $groomAddress = $request->getParsedBody()['groomAddress'];
        $brideName = $request->getParsedBody()['brideName'];
        $brideBirthDate = new \DateTime($request->getParsedBody()['brideBirthdate']);
        $brideEmail = $request->getParsedBody()['brideEmail'];
        $bridePhone = $request->getParsedBody()['bridePhone'];
        $brideAddress = $request->getParsedBody()['brideAddress'];
        $typeOfEvent = $request->getParsedBody()['typeOfEvent'];
        $civilOrChurch = $request->getParsedBody()['civilOrChurch'];
        $eventDate = new \DateTime($request->getParsedBody()['eventDate']);
        $alternativeDates = $request->getParsedBody()['alternativeDates'];
        $closedDate = new \DateTime($request->getParsedBody()['closedDate']);
        $tastingDate =new \DateTime( $request->getParsedBody()['tastingDate']);
        $nif = $request->getParsedBody()['nif'];
        $signalAmmount = $request->getParsedBody()['signalAmmount'];
        if (isset( $request->getParsedBody()['lights'])) { $lights=1; } else { $lights = 0;}
        if (isset( $request->getParsedBody()['rooms'])) { $rooms= 1; } else { $rooms = 0;}
        if (isset( $request->getParsedBody()['menu'])) { $menu = 1; } else { $menu = 0;}
        if (isset( $request->getParsedBody()['fireworks'])) { $fireworks= 1; } else { $fireworks = 0;}
        $fireType = $request->getParsedBody()['fireType'];
        $observations = $request->getParsedBody()['observations'];
        if(isNull($fireType))
        {
            $fireType="";
        }
        try {
            $this->clientRepository->findByEmail($groomEmail);
            throw new InvalidArgumentException("Client Already exist");
        } catch (ClientNotFoundException $ignore) {
        }


        $user = $this->clientRepository->add(
            new Client(
                id: -1,
                groomName: $groomName,
                brideName: $brideName,
                groomBirthdate: $groomBirthDate,
                brideBirthdate: $brideBirthDate,
                groomEmail: $groomEmail,
                brideEmail: $brideEmail,
                groomPhone: $groomPhone,
                bridePhone: $bridePhone,
                groomAddress: $groomAddress,
                brideAddress: $brideAddress,
                typeOfEvent: $typeOfEvent,
                civilOrChurch: $civilOrChurch,
                eventDate: $eventDate,
                alternativeDates: $alternativeDates,
                closedDate: $closedDate,
                tastingDate: $tastingDate,
                nif: $nif,
                signalAmmount: $signalAmmount,
                lights: $lights,
                rooms: $rooms,
                menu: $menu,
                fireworks: $fireworks,
                fireType: $fireType,
                observations: $observations
            )
        );
        //$this->logger->info("New user added", ["id" => $user->id]);
        $this->logger->info("New user added", []);

        /*EmailHandler::SendWelcomeEmail(
            $user,
            $router->fullUrlFor($request->getUri(),'home',['id'=>$user->id,'recoverPassword'=>$recoverPassword]),
            $twig
        );*/


        return $response->withStatus(301)->withHeader('Location', $router->urlFor('viewClientList'));
    }

}

