<?php

namespace App\Services;

use App\Repositories\PedidoRepository;

class PedidoService extends BaseService
{
    function __construct(PedidoRepository $pedidoRepository)
    {
        parent::__construct($pedidoRepository);
    }

}
