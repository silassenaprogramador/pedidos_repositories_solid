<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemPedido;
use App\Traits\CrudTraitController;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{

    private $model;

    public function __construct(Pedido $pedido)
    {
        $this->model = $pedido;
    }

    use CrudTraitController;

    public function index(){

        return view('admin.pedidos');
    }

    /**
     *
     */
    public function store(Request $request){

        try {

            $request->merge(['status'=>'novo']);

            $this->traitStore($request);

            if($this->model->id != ""){

                foreach($request->produto_id as $key => $produto_id){

                    ItemPedido::create([

                        'produto_id' => $produto_id,
                        'pedido_id' => $this->model->id ,
                        'nome' => $request->produto[$key] ,
                        'quantidade' => $request->quantidade[$key] ,
                        'valor' => $request->valor[$key] ,
                        'valor_total' => $request->total[$key]
                    ]);
                }
            }

            return response()->json($this->model, 200);

        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }

    /**
     *
     */
    public function update(Request $request, $id){

        try {

            $this->traitUpdate($request, $id);

            //removendo todos os itens do pedido pelo collection
            $this->model->itemPedido->map(function($item,$key){

                $item->forceDelete();
            });

            //salvandos os itens do pedidos que nao foram apagados no front-end
            if(isset($request->produto)){

                foreach($request->produto as $key => $nome_produto){

                    ItemPedido::create([

                        'produto_id' => $request->produto_id[$key],
                        'pedido_id' => $this->model->id ,
                        'nome' => $nome_produto ,
                        'quantidade' => $request->quantidade[$key] ,
                        'valor' => $request->valor[$key] ,
                        'valor_total' => $request->total[$key]
                    ]);
                }
            }

            return response()->json($this->model, 200);

        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }

}
