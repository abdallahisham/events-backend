<?php

return [
    App\Repositories\Contracts\EventRepository::class =>
        App\Repositories\EventRepositoryEloquent::class,

    App\Repositories\Contracts\UsersRepository::class =>
        App\Repositories\UsersRepositoryEloquent::class,
];