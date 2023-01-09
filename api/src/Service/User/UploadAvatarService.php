<?php


namespace App\Service\User;


use App\Entity\User;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarService
{
    public function __construct()
    {

    }

    public function uploadAvatar(Request $request, User $user): User
    {
        $user = new User($name, $email);
        $user->setPassword($this->encoderService->generateEncodedPassword($user, $password));

        try {
            $this->userRepository->save($user);
        } catch (ORMException $exception) {
            throw UserAlreadyExistsException::fromEmail($email);
        }

        //envío email de activación al usuario

        return $user;
    }
}