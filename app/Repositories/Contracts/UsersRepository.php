<?php

namespace App\Repositories\Contracts;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UsersRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface UsersRepository extends RepositoryInterface
{
    public function login(array $data);
}
