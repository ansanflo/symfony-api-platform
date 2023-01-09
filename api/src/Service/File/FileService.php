<?php


namespace App\Service\File;


use App\Entity\User;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class FileService
{
    public function __construct()
    {

    }

    public function uploadFile(UploadedFile $file, string $prefix): string
    {

    }

    public function deleteFile(?string $path): void
    {

    }
}