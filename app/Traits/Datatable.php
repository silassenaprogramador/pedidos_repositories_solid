<?php

namespace App\Traits;


use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait Datatable{

     /**
     *
     */
    public function datatables()
    {

        try {

            $lista = $this->model::query();

            $lista_json = datatables($lista)
                ->addColumn('action', function ($row) {
                    $action =  "<a href='javascript:;' onclick='editar($row->id)' class='btn btn-primary' title='Editar'><i class='fa fa-edit'></i></a>
                            <a href='#' onclick='deletar($row->id)' class='btn btn-danger' title='Remover'><i class='fa fa-trash'></i></a>";
                    return $action;
                })
                ->rawColumns(['action'])
                ->toJson();

            return $lista_json;

        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }
}
