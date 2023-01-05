<?php


namespace App\Repository;


use App\Entity\User;
use App\Exceptions\User\UserNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class UserRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return User::class;
    }

    public function findOnyById(string $id): User
    {
        if(null === $user = $this->objectRepository->find($id)) {
            throw UserNotFoundException::fromId($id);
        }

        return $user;
    }

    public function getOnyByEmailOrFail(string $email): User
    {
        if(null === $user = $this->objectRepository->findOneBy(['email' => $email])) {
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }

    public function getOneInactiveByIdAndTokenOrFail(string $id, string $token): User
    {
        if(null === $user = $this->objectRepository->findOneBy(['id' => $id, 'token' => $token, 'active' => false])) {
            throw UserNotFoundException::fromUserIdAndToken($id, $token);
        }

        return $user;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user): void
    {
        $this->saveEntity($user);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $user): void
    {
        $this->removeEntity($user);
    }
}