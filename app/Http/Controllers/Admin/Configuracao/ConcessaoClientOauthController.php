<?php

namespace App\Http\Controllers\Admin\Configuracao;

use Tools;
use App\Services\OauthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConcessaoClientOauthController extends Controller
{

    public function __construct(OauthService $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    /**
     *
     */
    public function habilitarConcessaoSenhaClient(Request $request){

        try{

            $this->oauthService->habilitarClient($request->id);

            return response()->json('success',200);

        }catch(Exception $e){

            return response()->json(['error'=> Tools::formataExcecao($e)], 400);
        }
    }

}
