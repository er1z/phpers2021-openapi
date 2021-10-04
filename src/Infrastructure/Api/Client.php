<?php

declare(strict_types=1);

namespace App\Infrastructure\Api;

class Client extends \App\Infrastructure\Api\Runtime\Client\Client
{
    /**
     * @param int    $id    User ID
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Infrastructure\Api\Model\User|\Psr\Http\Message\ResponseInterface|null
     */
    public function getUserById(int $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Infrastructure\Api\Endpoint\GetUserById($id), $fetch);
    }

    public static function create($httpClient = null, array $additionalPlugins = [])
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
            $plugins = [];
            if (\count($additionalPlugins) > 0) {
                $plugins = array_merge($plugins, $additionalPlugins);
            }
            $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        }
        $requestFactory = \Http\Discovery\Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = \Http\Discovery\Psr17FactoryDiscovery::findStreamFactory();
        $serializer = new \Symfony\Component\Serializer\Serializer([new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(), new \App\Infrastructure\Api\Normalizer\JaneObjectNormalizer()], [new \Symfony\Component\Serializer\Encoder\JsonEncoder(new \Symfony\Component\Serializer\Encoder\JsonEncode(), new \Symfony\Component\Serializer\Encoder\JsonDecode(['json_decode_associative' => true]))]);

        return new static($httpClient, $requestFactory, $serializer, $streamFactory);
    }
}
