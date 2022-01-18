<?php

use Illuminate\Support\Facades\Validator;

/**
 *
 */
function helpers_validar_campos($campos,$regras,$menssagens = []){

    if(empty($campos)){
        throw new Exception('Nenhum campo enviado para validação!');
    }

    if(empty($regras)){
        throw new Exception('Nenhuma regra enviada para validação!');
    }

    //sem menssagens personalizadas
    if(count($menssagens) == 0){

        $validator = Validator::make($campos,$regras);

        if ($validator->fails()) {

            return ['response' => $validator->errors(), 'status' => 422];
        }

        return ['response' => "", 'status' => 200];
    }

    //aplicando menssagens personalizadas
    $validator = Validator::make($campos,$regras,$menssagens);

    if ($validator->fails()) {

        return ['response' => $validator->errors(), 'status' => 422];
    }

    return ['response' => "", 'status' => 200];
}

function formataExcecao($e){

    return [
            "error"=>[
                'messagen'=>$e->getMessage(),
                'file'=>$e->getFile(),
                'line'=>$e->getLine()
                ]
            ];
}
