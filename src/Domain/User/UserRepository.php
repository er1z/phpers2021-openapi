<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    public function find(int $id): ?User;
}
