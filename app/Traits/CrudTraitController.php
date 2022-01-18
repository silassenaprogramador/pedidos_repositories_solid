<?php

namespace App\Traits;


use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait CrudTraitController{

    /**
     *
     */
    public function index(){

        return $this->traitIndex();
    }
    /**
     *
     */
    public function traitIndex(){

        try {

            $lista = $this->model->paginate();

            return response()->json($lista, 200);

        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }

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

    /**
     *
     */
    public function store(Request $request)
    {
        return $this->traitStore($request);
    }


    /**
     *
     */
    public function traitStore(Request $request)
    {

        try {

            $campos = $request->all();

            $validacao = $this->validacao($campos, $this->model);

            if ($validacao['status'] == 422) {
                return response()->json($validacao['response'], $validacao['status']);
            }

            $this->model->fill($campos);
            $this->model->save();
            $this->model->refresh();

            return response()->json($this->model, 200);

        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }

    /**
     *
     */
    public function show($id)
    {

        try {

            $model = $this->model::find($id);

            return response()->json($model, 200);

        } catch (\Exception $e) {

           return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }


    /**
     *
     **/
    public function update(Request $request, $id)
    {

        return $this->traitUpdate($request, $id);
    }

    /**
     *
     */
    public function traitUpdate(Request $request, $id)
    {

        try {

            $campos = $request->all();

            $validacao = $this->validacao($campos, $this->model, $id);

            if ($validacao['status'] == 422) {
                return response()->json($validacao['response'], $validacao['status']);
            }

            $this->model = $this->model::find($id);
            $this->model->fill($campos);
            $this->model->save();
            $this->model->refresh();

            return response()->json($this->model, 200);
        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }

    /**
     * ATENÇÃO ANTES DE USAR ESSE METODO
     * CERTIFIQUE DE QUE O MODEL ESTA CONFIGURADO COM SOFTDELETE
     * PARA EVITAR DOR DE CABEÇA
     */
    public function destroy($id)
    {

        try {

            $del = $this->model::find($id);

            $status_del = $del->delete();

            return response()->json(['msg' => $status_del], 200);

        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }

    /**
     *
     */
    private function validacao($campos, $model, $id = null)
    {

        if (method_exists($model, 'rules')) {

            if (method_exists($model, 'message')) {

                $validator = Validator::make($campos, $model->rules($id), $model->message());
            } else {

                $validator = Validator::make($campos, $model->rules($id));
            }

            if ($validator->fails()) {
                return ['response' => $validator->errors(), 'status' => 422];
            }
        }

        return ['response' => true, 'status' => 200];
    }
}
