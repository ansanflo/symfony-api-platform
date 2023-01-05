<?php


namespace App\Exceptions\User;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends NotFoundHttpException
{
    private const MESSAGE = 'User with email %s not found';

    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf(self::MESSAGE, $email));
    }

    public static function fromUserIdAndToken(string $id, $token): self
    {
        throw new self(\sprintf('User with ID %s and token %s not found', $id, $token));
    }

    public static function fromId(string $id)
    {
        throw new self(\sprintf('User with ID %s not found', $id));
    }
}