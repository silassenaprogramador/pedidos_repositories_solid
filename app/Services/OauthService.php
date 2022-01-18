<?php

namespace App\Services;

use App\Repositories\OauthRepository;

class OauthService
{
    protected $repository;

    public function __construct(OauthRepository $oauthRepository)
    {
        $this->repository = $oauthRepository;
    }

    public function habilitarClient($id){

        return $this->repository->updateClient($id,['password_client' => 1 ]);
    }
}
