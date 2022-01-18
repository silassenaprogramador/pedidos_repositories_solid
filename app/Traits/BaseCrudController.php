<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;

trait BaseCrudController{


    /**
     *
     */
    public function store(Request $request){

        try{

            $this->serviceModel->save($request->all());

            return response()->json('Sucesso',200);

        }catch(Exception $e){

            return response()->json(formataExcecao($e),400);
        }
    }

     /**
     *
     */
    public function update(Request $request,$id){

        try{

            $this->serviceModel->update($id,$request->all());

            return response()->json('Sucesso',200);

        }catch(Exception $e){

            return response()->json(formataExcecao($e),400);
        }
    }

    /**
     *
     */
    public function all(){

        try{

            $data = $this->serviceModel->all();

            return response()->json($data, 200);

        }catch(Exception $e){

            return response()->json(formataExcecao($e),400);
        }
    }


     /**
     *
     */
    public function show($id){

        try{

            $data = $this->serviceModel->get($id);

            return response()->json($data, 200);

        }catch(Exception $e){

            return response()->json(formataExcecao($e),400);
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

            $del = $this->serviceModel->get($id);

            $status_del = $del->delete();

            return response()->json(['msg' => $status_del], 200);

        } catch (\Exception $e) {

            return response()->json(['errors' => formataExcecao($e)], 400);
        }
    }



    /**
     *
     */
     public function datatables(){

       try{

           return $this->serviceModel->datatables();

        }catch(Exception $e){

            return response()->json(formataExcecao($e),400);
        }
    }


}
