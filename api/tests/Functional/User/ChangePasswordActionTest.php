<?php


namespace App\Tests\Functional\User;


use App\Tests\Functional\TestBase;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChangePasswordActionTest extends UserTestBase
{
    public function testChangePassword(): void
    {
        $payload = [
            'oldPassword' => 'password',
            'newPassword' => 'newpassword'
        ];

        self::$angel->request('PUT', sprintf('%s/%s/change_password', $this->endpoint, $this->getAngelId()),
            [], [], [], json_encode($payload));

        $response = self::$angel->getResponse();

        $this->assertNotEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testChangePasswordWithInvalidOldPassword(): void
    {
        $payload = [
            'oldPassword' => 'invalidpassword',
            'newPassword' => 'newpassword'
        ];

        self::$angel->request('PUT', sprintf('%s/%s/change_password', $this->endpoint, $this->getAngelId()),
            [], [], [], json_encode($payload));

        $response = self::$angel->getResponse();

        $this->assertNotEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

}