<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemPedido;

use App\Models\Pedido;
use App\Services\PedidoService;
use App\Traits\BaseCrudController;
use Illuminate\Http\Request;

class PedidoController extends Controller
{

    private $serviceModel;

    public function __construct(PedidoService $pedidoService)
    {
        $this->serviceModel = $pedidoService;
    }

    use BaseCrudController;

    public function index(){

        return view('admin.pedidos');
    }

}
