<?php


namespace App\Service\User;


use App\Entity\User;
use App\Exceptions\Password\PasswordException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class ChangePasswordService
{
    private UserRepository $userRepository;
    private EncoderService $encoderService;

    public function __construct(UserRepository $userRepository, EncoderService $encoderService)
    {
        $this->userRepository = $userRepository;
        $this->encoderService = $encoderService;
    }

    public function changePassword(string $userId, string $oldPassword, string $newPassword): User
    {
        $user = $this->userRepository->findOnyById($userId);

        if(!$this->encoderService->isValidPassword($user, $oldPassword)) {
            throw PasswordException::oldPasswordDoesNotMatch();
        }

        $user->setPassword($this->encoderService->generateEncodedPassword($user, $newPassword));
        $this->userRepository->save($user);

        return $user;
    }
}