<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $primaryKey = 'id';

    /* The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nome',
        'valor'
    ];

    public static function rules($id=null)
    {
        return [
            'nome' => 'required',
            'valor' => 'required|numeric'
        ];
    }

    public static function message(){

        return [
            'nome.required'=>"Campo 'Nome' é obrigatório!",
            'valor.required'=>"Campo 'Valor' é obrigatório!",
            'valor.numeric'=>"Campo 'Valor' não é um numero válido!"
        ];
    }

    public function itemPedido(){

        return $this->hasMany(ItensPedido::class);
    }
}
