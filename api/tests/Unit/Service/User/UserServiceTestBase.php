<?php


namespace App\Tests\Unit\Service\User;

use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTestBase extends TestCase
{
    /** @var UserRepository|MockObject */
    protected $userRepository;

    /** @var EncoderService|MockObject */
    protected  $encoderService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $this->encoderService = $this->getMockBuilder(EncoderService::class)->disableOriginalConstructor()->getMock();
    }
}