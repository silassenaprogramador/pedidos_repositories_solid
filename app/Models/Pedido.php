<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $with = ['cliente','itemPedido'];

    /* The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'cliente_id',
        'valor_total',
        'status'
    ];

    public function cliente(){

        return $this->belongsTo(Cliente::class);
    }

    public function itemPedido(){

        return $this->hasMany(ItemPedido::class,'pedido_id');
    }
}
