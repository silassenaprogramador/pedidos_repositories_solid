<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Services\ProdutoService;
use App\Traits\BaseCrudController;
use Exception;

class ProdutoController extends Controller
{

    private $serviceModel;

    public function __construct(ProdutoService $produtoServico)
    {
        $this->serviceModel = $produtoServico;
    }

    use BaseCrudController;

    public function index(){

        return view('admin.produtos');
    }

     /**
     * metedo adaptado para usar com auto-complete
     */
    public function getProdutosPorNome($nome){

        try{

            $lista = $this->serviceModel->buscaPorNome($nome);

            return response()->json($lista, 200);

        }catch(Exception $e){

            return response()->json(['errors' => formataExcecao($e)], 400);
        }

    }

}
