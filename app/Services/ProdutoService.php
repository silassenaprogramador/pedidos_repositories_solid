<?php

namespace App\Services;

use App\Repositories\ProdutoRepository;

class ProdutoService extends BaseService
{
    function __construct(ProdutoRepository $produtoRepository)
    {
        parent::__construct($produtoRepository);
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
