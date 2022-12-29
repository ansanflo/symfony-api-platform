<?php


namespace App\Exceptions\Password;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordException extends BadRequestHttpException
{
    private const MESSAGE = 'User with email %s not found';

    public static function invalidLength(): self
    {
        throw new self('Password must be at least 6 characters');
    }
}