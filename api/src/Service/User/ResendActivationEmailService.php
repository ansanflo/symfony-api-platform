<?php


namespace App\Service\User;


use App\Entity\User;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Exceptions\User\UserIsActiveException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class ResendActivationEmailService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function resend(string $email): void
    {
        $user = $this->userRepository->findOneByEmailOrFail($email);
        if($user->isActive()) {
            throw UserIsActiveException::fromEmail($email);
        }

        $user->setToken(sha1(uniqid()));
        $this->userRepository->save($user);

        //envío email de activación al usuario
    }
}