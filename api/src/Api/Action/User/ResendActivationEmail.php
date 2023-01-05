<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\ResendActivationEmailService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ResendActivationEmail
{
    private ResendActivationEmailService $resendActivationEmailService;

    public function __construct(ResendActivationEmailService $resendActivationEmailService)
    {
        $this->resendActivationEmailService = $resendActivationEmailService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $email = RequestService::getField($request, 'email');
        $this->resendActivationEmailService->resend($email);

        return new JsonResponse(['message' => 'Activation email sent']);
    }
}