<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\BaseCrudController;

use App\Services\ClienteService;
use Exception;

class ClienteController extends Controller
{

    protected $serviceModel;

    use BaseCrudController;

    function __construct(ClienteService $clienteService)
    {
        $this->serviceModel = $clienteService;
    }

    public function index(){

        return view('admin.clientes');
    }

    /**
     * metedo adaptado para usar com auto-complete
     */
    public function getClientesPorNome($nome){

        try{

            $lista = $this->serviceModel->buscaPorNome($nome);

            return response()->json($lista, 200);

        }catch(Exception $e){

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }


}
