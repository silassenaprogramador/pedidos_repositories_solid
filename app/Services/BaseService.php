<?php

namespace App\Services;

class BaseService{


    function __construct(Object $obj)
    {
        $this->repository = $obj;
    }

    /**
     *
     */
    public function save($dados){

        return $this->repository->save($dados);
    }

    /**
     *
     */
    public function all(){

        return $this->repository->all();
    }

    /**
     *
     */
    public function update($id,$dados){

        return $this->repository->update($id,$dados);
    }


    /**
     *
     */
    public function get($id){

        return $this->repository->find($id);
    }

      /**
     *
     */
    public function getByColumns($where = []){

        return $this->repository->findByColumn($where);
    }

      /**
     *
     */
    public function datatables()
    {

        return $this->repository->datatables();
    }
}
