<?php

namespace App\Repositories;

use App\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\UserRepository;
use App\User;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    private $http;
    private $apiClient;

    public function __construct(Application $app, Client $http, ApiClient $apiClient)
    {
        parent::__construct($app);
        $this->http = $http;
        $this->apiClient = $apiClient;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function login(array $data)
    {
        $this->apiClient->setCredentials($data['email'], $data['password']);
        try {
            $res = $this->http->post($this->apiClient->getDefaultUrl(), [
                'form_params' => $this->apiClient->toArray()
            ]);
        } catch (ClientException $e) {
            throw new AuthenticationException();
        }
        return json_decode((string)$res->getBody(), true);
    }

    public function authenticatedUser(): User
    {
        return request()->user();
    }

}
