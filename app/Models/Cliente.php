<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
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
        'email',
        'telefone',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'uf'
    ];

    public static function rules($id=null)
    {

        if($id){

            return [
                'nome' => 'required',
                'email' => 'required|email|unique:clientes,email,'.$id
            ];
        }

        return [
            'nome' => 'required',
            'email' => 'required|email|unique:clientes,email'
        ];
    }

    public static function message(){

        return [
            'nome.required'=>"Campo 'Nome' é obrigatório!",
            'email.required'=>"Campo 'E-mail' é obrigatório!",
            'email.email'=>"Campo 'E-mail' não é e-mail válido!",
            'email.unique'=>"Campo 'E-mail' já vinculado em outro cliente",

        ];
    }

    public function pedido(){

        return $this->hasMany(Pedido::class);
    }
}
