<?php


namespace App\Service\User;


use App\Entity\User;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Exceptions\User\UserIsActiveException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class ActivateAccountService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function activate(string $id, string $token): User
    {
        $user = $this->userRepository->findOneInactiveByIdAndTokenOrFail($id, $token);

        $user->setActive(1);
        $user->setToken(null);
        $this->userRepository->save($user);

        return $user;
    }
}