<?php


namespace App\Tests\Functional\User;


use App\Tests\Functional\TestBase;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterActionTest extends UserTestBase
{
    public function testRegister(): void
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@gmail.com',
            'password' => '123456'
        ];

        self::$client->request('POST', sprintf('%s/register', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['email'], $responseData['email']);
    }

    public function testRegisterWithMissingParameters(): void
    {
        $payload = [
            'name' => 'John',
            'password' => '123456'
        ];

        self::$client->request('POST', sprintf('%s/register', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$client->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testRegisterWithInvalidPassword(): void
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@gmail.com',
            'password' => '123'
        ];

        self::$client->request('POST', sprintf('%s/register', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$client->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}