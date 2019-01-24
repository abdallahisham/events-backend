<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class ApiClient implements Arrayable
{
    protected $defaultUrl;
    protected $clientId;
    protected $clientSecret;
    protected $grantType;
    protected $username;
    protected $password;

    public function __construct(array $config)
    {
        $this->defaultUrl = $config['default_url'];
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->grantType = $config['grant_type'];
    }

    public function setCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getDefaultUrl()
    {
        return $this->defaultUrl;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => $this->grantType,
            'username' => $this->username,
            'password' => $this->password
        ];
    }
}
