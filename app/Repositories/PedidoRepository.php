<?php

namespace App\Repositories;

use App\Models\ItemPedido;
use App\Models\Pedido;

class PedidoRepository extends BaseRepository
{

    protected $itemPedido;

    function __construct(Pedido $pedido, ItemPedido $itemPedido)
    {
        parent::__construct($pedido);

        $this->itemPedido =  $itemPedido;
    }


    public function datatables()
    {

        return datatables($this->model->with(['cliente']))
            ->addColumn('action', function ($row) {
                $action =  "<a href='javascript:;' onclick='editar($row->id)' class='btn btn-primary' title='Editar'><i class='fa fa-edit'></i></a>
                        <a href='#' onclick='deletar($row->id)' class='btn btn-danger' title='Remover'><i class='fa fa-trash'></i></a>";
                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function save($dados):bool
    {

        $dados['status'] = 'novo';

        $this->model->fill($dados);
        $this->model->save();

        if($this->model->id != ""){

            foreach($dados['produto_id'] as $key => $produto_id){

                $this->itemPedido->create([

                    'produto_id' => $produto_id,
                    'pedido_id' => $this->model->id ,
                    'nome' => $dados['produto'][$key],
                    'quantidade' => $dados['quantidade'][$key] ,
                    'valor' => $dados['valor'][$key] ,
                    'valor_total' => $dados['total'][$key]
                ]);
            }
        }

        return true;
    }

    /**
     *
     */
    public function update($id, $dados):bool
    {

        $this->model = $this->model->find($id);

        $this->model->fill($dados);
        $this->model->save();

        //removendo todos os itens do pedido pelo collection
        $this->model->itemPedido->map(function($item,$key){

            $item->forceDelete();
        });

        //salvandos os itens do pedidos que nao foram apagados no front-end
        if(isset($dados['produto_id'])){

            foreach($dados['produto'] as $key => $nome_produto){

                ItemPedido::create([

                    'produto_id' => $dados['produto_id'][$key],
                    'pedido_id' => $this->model->id ,
                    'nome' => $nome_produto ,
                    'quantidade' => $dados['quantidade'][$key] ,
                    'valor' => $dados['valor'][$key] ,
                    'valor_total' => $dados['total'][$key]
                ]);
            }
        }

        return true;
    }

}
