<?php

namespace App\Services;

use App\Repositories\ClienteRepository;

class ClienteService extends BaseService
{

    function __construct(ClienteRepository $clienteRepository)
    {
        parent::__construct($clienteRepository);
    }

    /**
     *
     */
    public function buscaPorNome($nome){

        $filtros = [
            ['nome',"like","%$nome%"]
        ];

        return $this->repository->getByColumnsPaginado($filtros);
    }
}
