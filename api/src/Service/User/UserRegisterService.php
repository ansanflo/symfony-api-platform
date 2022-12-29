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

    public function create(Request $request): User
    {
        $name = RequestService::getField($request, 'name');
        $email = RequestService::getField($request, 'email');
        $pasword = RequestService::getField($request, 'password');

        $user = new User($name, $email);
        $user->setPassword($this->encoderService->generateEncodedPassword($user, $pasword));

        try {
            $this->userRepository->save($user);
        } catch (\Exception $exception) {
            throw UserAlreadyExistsException::fromEmail($email);
        }

        return $user;
    }
}