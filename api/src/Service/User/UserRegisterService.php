<?php


namespace App\Service\User;


use App\Entity\User;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterService
{
    private UserRepository $userRepository;
    private EncoderService $encoderService;

    public function __construct(UserRepository $userRepository, EncoderService $encoderService)
    {
        $this->userRepository = $userRepository;
        $this->encoderService = $encoderService;
    }

    public function create(string $name, string $email, string $password): User
    {
        $user = new User($name, $email);
        $user->setPassword($this->encoderService->generateEncodedPassword($user, $password));

        try {
            $this->userRepository->save($user);
        } catch (\Exception $exception) {
            throw UserAlreadyExistsException::fromEmail($email);
        }

        //envío email de activación al usuario

        return $user;
    }
}