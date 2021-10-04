<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\User\User;
use App\Domain\User\UserRepository as UserRepositoryInterface;
use App\Infrastructure\Api\Client;

class UserRepository implements UserRepositoryInterface
{
    private Client $api;

    public function __construct(Client $api)
    {
        $this->api = $api;
    }


    public function find(int $id): ?User
    {
        $result = $this->api->getUserById($id);
        if(!$result) {
            return null;
        }

        return new User(
            $result->getId(),
            $result->getName()
        );
    }
}






















