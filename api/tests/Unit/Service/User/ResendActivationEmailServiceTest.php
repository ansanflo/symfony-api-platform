<?php


namespace App\Tests\Unit\Service\User;


use App\Entity\User;
use App\Exceptions\User\UserIsActiveException;
use App\Exceptions\User\UserNotFoundException;
use App\Service\User\ResendActivationEmailService;
use Symfony\Component\Uid\Uuid;

class ResendActivationEmailServiceTest extends UserServiceTestBase
{
    private ResendActivationEmailService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new ResendActivationEmailService($this->userRepository);
    }

    public function testResendActivationEmail(): void
    {
       $email = 'user@email.com';
       $user = new User('name', $email);

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneByEmailOrFail')
            ->with($email)
            ->willReturn($user);

        $this->service->resend($email);
    }

    public function testResendActivationEmailForActiveUser(): void
    {
        $email = 'user@email.com';
        $user = new User('name', $email);
        $user->setActive(1);
        $user->setToken(null);

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneByEmailOrFail')
            ->with($email)
            ->willReturn($user);

        $this->expectException(UserIsActiveException::class);

        $this->service->resend($email);
    }

}