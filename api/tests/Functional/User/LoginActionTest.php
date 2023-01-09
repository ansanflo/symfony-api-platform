<?php


namespace App\Tests\Functional\User;


use App\Tests\Functional\TestBase;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginActionTest extends UserTestBase
{
    public function testLogin(): void
    {
        $payload = [
            'username' => 'angel@gmail.com',
            'password' => 'password'
        ];

        self::$angel->request('POST', sprintf('%s/login_check', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$angel->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationSuccessResponse::class, $response);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $payload = [
            'username' => 'angel@gmail.com',
            'password' => 'invalidpassword'
        ];

        self::$angel->request('POST', sprintf('%s/login_check', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$angel->getResponse();

        $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationFailureResponse::class, $response);
    }
}