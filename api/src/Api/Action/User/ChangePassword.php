<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\ChangePasswordService;
use Symfony\Component\HttpFoundation\Request;

class ChangePassword
{
    private ChangePasswordService $changePasswordService;

    public function __construct(ChangePasswordService $changePasswordService)
    {
        $this->changePasswordService = $changePasswordService;
    }

    public function __invoke(Request $request, User $user): User
    {
        $oldPassword = RequestService::getField($request, 'oldPassword');
        $newPassword = RequestService::getField($request, 'newPassword');

        return $this->changePasswordService->changePassword($user->getId(), $oldPassword, $newPassword);
    }
}