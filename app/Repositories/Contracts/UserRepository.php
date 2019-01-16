<?php

namespace App\Repositories\Contracts;
use App\User;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface UserRepository extends RepositoryInterface
{
    public function login(array $data);

    public function authenticatedUser(): User;

    public function authenticatedUserId(): int;
}
