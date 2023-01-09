<?php


namespace App\Tests\Unit\Service\User;


use App\Entity\User;
use App\Exceptions\Password\PasswordException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Service\User\UserRegisterService;

class UserRegisterServiceTest extends UserServiceTestBase
{
    private UserRegisterService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new UserRegisterService($this->userRepository, $this->encoderService);
    }

    public function testUserRegister(): void
    {
        $name = 'username';
        $email = 'user@mail.com';
        $password = '123456';

        $user = $this->service->create($name, $email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
    }

    public function testUserRegisterForInvalidPassword(): void
    {
        $name = 'username';
        $email = 'user@mail.com';
        $password = '123';

        $this->encoderService
            ->expects($this->exactly(1))
            ->method('generateEncodedPassword')
            ->with($this->isType('object'), $this->isType('string'))
            ->willThrowException(new PasswordException());

        $this->expectException(PasswordException::class);

        $user = $this->service->create($name, $email, $password);
    }

    public function testUserRegisterForAlreadyExistingUser(): void
    {
        $name = 'username';
        $email = 'user@mail.com';
        $password = '123456';

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('save')
            ->with($this->isType('object'))
            ->willThrowException(new UserAlreadyExistsException(sprintf('User with email %s already exist', $email)));

        $this->expectException(UserAlreadyExistsException::class);

        $user = $this->service->create($name, $email, $password);
    }

}