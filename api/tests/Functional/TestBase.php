<?php


namespace App\Tests\Functional;


use Doctrine\DBAL\Connection;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestBase extends WebTestCase
{
    use FixturesTrait;
    use RecreateDatabaseTrait;

    protected static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $angel = null;
    protected static ?KernelBrowser $jose = null;
    protected static ?KernelBrowser $marc = null;

    protected function setUp(): void
    {
        if(null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameters(
                [
                    'CONTENT_TYPE' => 'application/json',
                    'HTTP_ACCEPT' => 'application/ld+json'
                ]
            );
        }

        if(null === self::$angel) {
            self::$angel = clone self::$client;
            $this->createAuthenticatedUser(self::$angel, 'angel@gmail.com');
        }
        if(null === self::$jose) {
            self::$jose = clone self::$client;
            $this->createAuthenticatedUser(self::$jose, 'jose@gmail.com');
        }
        if(null === self::$marc) {
            self::$marc = clone self::$client;
            $this->createAuthenticatedUser(self::$marc, 'marc@gmail.com');
        }
    }

    private function createAuthenticatedUser(KernelBrowser &$client, string $email): void
    {
        $user = $this->getContainer()->get('App\Repository\UserRepository')->findOneByEmailOrFail($email);
        $token = $this
            ->getContainer()
            ->get('Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface')
            ->create($user);

        $client->setServerParameters(
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json',
                'HTTP_Authorization' => sprintf('Bearer %s', $token)
            ]
        );
    }

    protected function getResponseData(Response $response): array
    {
        return json_decode($response->getContent(), true);
    }

    protected function initDbConnection(): Connection
    {
        return $this->getContainer()->get('doctrine')->getConnection();
    }

    protected function getAngelId(): string
    {
        return $this->initDbConnection()->query('SELECT id FROM user WHERE email = "angel@gmail.com"')->fetchFirstColumn()[0];
    }
    protected function getJoseId(): string
    {
        return $this->initDbConnection()->query('SELECT id FROM user WHERE email = "jose@gmail.com"')->fetchFirstColumn()[0];
    }
    protected function getMarcId(): string
    {
        return $this->initDbConnection()->query('SELECT id FROM user WHERE email = "marc@gmail.com"')->fetchFirstColumn()[0];
    }
}