<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\UploadAvatarService;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatar
{
    private UploadAvatarService $uploadAvatarService;

    public function __construct(UploadAvatarService $uploadAvatarService)
    {
        $this->uploadAvatarService = $uploadAvatarService;
    }

    public function __invoke(Request $request, User $user): User
    {
        $name = RequestService::getField($request, 'name');

        return $this->uploadAvatarService->uploadAvatar($request, $user);
    }
}