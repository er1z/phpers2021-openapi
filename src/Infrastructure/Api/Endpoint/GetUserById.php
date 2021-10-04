<?php

declare(strict_types=1);

namespace App\Infrastructure\Api\Endpoint;

class GetUserById extends \App\Infrastructure\Api\Runtime\Client\BaseEndpoint implements \App\Infrastructure\Api\Runtime\Client\Endpoint
{
    protected $id;

    /**
     * @param int $id User ID
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    use \App\Infrastructure\Api\Runtime\Client\EndpointTrait;

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/users/{id}');
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return [[], null];
    }

    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    /**
     * {@inheritdoc}
     *
     * @return \App\Infrastructure\Api\Model\User|null
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (false === (null === $contentType) && (200 === $status && false !== mb_strpos($contentType, 'application/json'))) {
            return $serializer->deserialize($body, 'App\\Infrastructure\\Api\\Model\\User', 'json');
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
