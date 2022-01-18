<?php

namespace App\Repositories;

use Laravel\Passport\Client;

class OauthRepository
{
    protected $clientOauth;

    function __construct(Client $client)
    {
        $this->clientOauth = $client;
    }

    public function getClientById($id){

        return $this->clientOauth->where("id", $id)->first();
    }

    public function updateClient(int $id, array $attributes): bool
    {
        return $this->clientOauth->find($id)->update($attributes);
    }
}
