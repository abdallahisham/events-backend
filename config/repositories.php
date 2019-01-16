<?php

return [
    App\Repositories\Contracts\EventRepository::class =>
        App\Repositories\EventRepositoryEloquent::class,

    App\Repositories\Contracts\UserRepository::class =>
        App\Repositories\UserRepositoryEloquent::class,
];