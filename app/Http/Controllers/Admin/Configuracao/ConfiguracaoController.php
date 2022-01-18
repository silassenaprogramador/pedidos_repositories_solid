<?php

namespace App\Http\Controllers\Admin\Configuracao;

use Exception;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

use Illuminate\Routing\Controller as BaseController;

class ConfiguracaoController extends BaseController
{
    public function __construct(){

    }

    public function index(){

        return view('admin.configuracao.acessoexterno');
    }
}
