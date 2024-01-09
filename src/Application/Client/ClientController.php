<?php
namespace App\Application\Client;

use App\Domain\Client\ClientNotFoundException;
use App\Domain\Client\ClientRepository;
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


    public function addClient(Request              $request,
                            Response             $response,
                            Environment          $twig,
                            RouteParserInterface $router): Response|Message
    {
        $groomName = $request->getParsedBody()['groomName'];
        $groomBirthDate = $request->getParsedBody()['groomBirthdate'];
        $groomEmail = $request->getParsedBody()['groomEmail'];
        $groomPhone = $request->getParsedBody()['groomPhone'];
        $groomAddress = $request->getParsedBody()['groomAddress'];
        $brideName = $request->getParsedBody()['brideName'];
        $brideBirthDate = $request->getParsedBody()['brideBirthdate'];
        $brideEmail = $request->getParsedBody()['brideEmail'];
        $bridePhone = $request->getParsedBody()['bridePhone'];
        $brideAddress = $request->getParsedBody()['brideAddress'];
        $typeOfEvent = $request->getParsedBody()['typeOfEvent'];
        $civilOrChurch = $request->getParsedBody()['civilOrChurch'];
        $eventDate = $request->getParsedBody()['eventDate'];
        $alternativeDates = $request->getParsedBody()['alternativeDates'];
        $closedDate = $request->getParsedBody()['closedDate'];
        $tastingDate = $request->getParsedBody()['tastingDate'];
        $nif = $request->getParsedBody()['nif'];
        $signalAmmount = $request->getParsedBody()['signalAmmount'];
        $lights = $request->getParsedBody()['lights'];
        $rooms = $request->getParsedBody()['rooms'];
        $menu = $request->getParsedBody()['menu'];
        $fireworks = $request->getParsedBody()['fireworks'];
        $fireType = $request->getParsedBody()['fireType'];
        $observations = $request->getParsedBody()['observations'];

        try {
            $this->clientRepository->findByEmail($groomEmail);
            throw new InvalidArgumentException("Client Already exist");
        } catch (ClientNotFoundException $ignore) {
        }


        $user = $this->clientRepository->add(
            new User(
                id: -1,
                groomFirstName: $groomName,
                groomBirthdate: $groomBirthDate,
                groomEmail: $groomEmail,
                groomPhone: $groomPhone,
                groomAddress: $groomAddress,
                brideFirstName: $brideName,
                brideBirthdate: $brideBirthDate,
                brideEmail: $brideEmail,
                bridePhone: $bridePhone,
                brideAddress: $brideAddress,
                typeOfEvent: $typeOfEvent,
                civilOrChurch: $civilOrChurch,
                eventDate: $eventDate,
                alternativeDates: $alternativeDates,
                nif: $nif,
                signalAmmount: $signalAmmount,
                closedDate: $closedDate,
                tastingDate: $tastingDate,
                lights: $lights,
                rooms: $rooms,
                menu: $menu,
                fireworks: $fireworks,
                fireType: $fireType,
                observations: $observations,
                createdAt:       null,
                updatedAt:       null
            )
        );
        //$this->logger->info("New user added", ["id" => $user->id]);
        $this->logger->info("New user added", []);

        /*EmailHandler::SendWelcomeEmail(
            $user,
            $router->fullUrlFor($request->getUri(),'home',['id'=>$user->id,'recoverPassword'=>$recoverPassword]),
            $twig
        );*/


        return $response->withStatus(301)->withHeader('Location', $router->urlFor('viewUsersList'));
    }

}

