<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPedido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pedido', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('pedido_id');
            $table->string('nome');
            $table->decimal('valor',10,2);
            $table->decimal('valor_total',10,2);
            $table->integer('quantidade');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_pedido');
    }
}
