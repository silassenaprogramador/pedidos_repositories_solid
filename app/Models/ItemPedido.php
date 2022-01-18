<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemPedido extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'item_pedido';

    /* The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'produto_id',
        'pedido_id',
        'nome',
        'quantidade',
        'valor',
        'valor_total'
    ];

    public function pedido(){

        return $this->belongsTo(Pedido::class);
    }

    public function produto(){

        return $this->belongsTo(Produto::class);
    }
}
