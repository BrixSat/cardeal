<?php

namespace App\Application\Admin;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\User\SqlUserRepository;
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

class AdminController
{
    use HttpResponse;

    public function __construct(public LoggerInterface $logger, public SqlUserRepository $userRepository) { }

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
    public function viewAddUserForm(Request $request, Response $response, Environment $twig): Response|Message
    {
        $response->getBody()->write($twig->render('pages/admin/add-user.twig', []));
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
    public function viewUsersList(Request $request, Response $response, Environment $twig): Response|Message
    {
        $userList = $this->userRepository->findAll();

        $response->getBody()->write($twig->render('pages/admin/list-users.twig', ["userList" => $userList]));
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * @param Request              $request
     * @param Response             $response
     * @param RouteParserInterface $router
     *
     * @return Response|Message
     * @throws \App\Infrastructure\DomainException\InvalidArgumentException
     */
    public function addUser(Request              $request,
                            Response             $response,
                            RouteParserInterface $router): Response|Message
    {
        $firstName = $request->getParsedBody()['firstName'];
        $lastName = $request->getParsedBody()['lastName'];
        $email = $request->getParsedBody()['email'];
        $password = $request->getParsedBody()['password'];

        try {
            $this->userRepository->findByEmail($email);
            throw new InvalidArgumentException("User Already exist");
        } catch (UserNotFoundException $ignore) { }

        $passwordHash = password_hash($password, null);

        $user = $this->userRepository->add(
            new User(
                id:              -1,
                username:        $firstName . '.' . $lastName,
                firstName:       $firstName,
                lastName:        $lastName,
                password:        $passwordHash,
                recoverPassword: '',
                email:           $email,
                jobTitle:        '',
                createdAt:       null,
                updatedAt:       null
            )
        );
        $this->logger->info("New user added", ["id" => $user->id]);

        /*EmailHandler::SendWelcomeEmail(
            $user,
            $router->fullUrlFor($request->getUri(),'home',['id'=>$user->id,'recoverPassword'=>$recoverPassword]),
            $twig
        );*/

        return $response->withStatus(301)
                        ->withHeader('Location', $router->urlFor('viewUsersList'));
    }

}

