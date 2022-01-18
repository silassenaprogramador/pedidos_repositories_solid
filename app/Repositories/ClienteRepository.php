<?php

namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository extends BaseRepository
{
    function __construct(Cliente $cliente)
    {
        parent::__construct($cliente);
    }

    function getByColumnsPaginado($where = []){

        return $this->model->where($where)->paginate();
    }

}
