<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository extends BaseRepository
{
    function __construct(Produto $produto)
    {
        parent::__construct($produto);
    }

    function getByColumnsPaginado($where = []){

        return $this->model->where($where)->paginate();
    }

}
