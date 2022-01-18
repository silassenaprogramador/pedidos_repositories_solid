<?php

namespace App\Helpers;

class Tools{

    /**
     *
     */
    public function formataExcecao($e){

        return [
                "error"=>[
                    'messagen'=>$e->getMessage(),
                    'file'=>$e->getFile(),
                    'line'=>$e->getLine()
                    ]
                ];
    }
}
