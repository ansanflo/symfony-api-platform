<?php


namespace App\Tests\Functional\User;


use App\Tests\Functional\TestBase;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResendActivationEmailActionTest extends UserTestBase
{
    public function testResendActivationEmail(): void
    {
        $payload = [
            'email' => 'marc@gmail.com',
        ];

        self::$marc->request('PUT', sprintf('%s/resend_activation_email', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$marc->getResponse();

        $this->assertNotEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testResendActivationEmailToActiveUser(): void
    {
        $payload = [
            'email' => 'angel@gmail.com',
        ];

        self::$angel->request('PUT', sprintf('%s/resend_activation_email', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$angel->getResponse();

        $this->assertNotEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
    }

}