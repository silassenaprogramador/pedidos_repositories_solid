<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;

class BaseRepository implements CrudInterface
{
    protected $model;

    function __construct(Object $model)
    {
        $this->model = $model;
    }

    public function all(): object
    {
        return $this->model->all();
    }

    public function find(int $id): object
    {
        return $this->model->find($id);
    }

    public function findByColumn($where = []): object
    {
        return $this->model->where($where)->get();
    }

    public function save(array $attributes): bool
    {
        $this->model->fill($attributes);

        return $this->model->save();
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->model->find($id)->update($attributes);
    }

    public function datatables()
    {

        return datatables($this->model::query())
            ->addColumn('action', function ($row) {
                $action =  "<a href='javascript:;' onclick='editar($row->id)' class='btn btn-primary' title='Editar'><i class='fa fa-edit'></i></a>
                        <a href='#' onclick='deletar($row->id)' class='btn btn-danger' title='Remover'><i class='fa fa-trash'></i></a>";
                return $action;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
