<?php

use App\Http\Controllers\Admin\Configuracao\ConcessaoClientOauthController;
use App\Http\Controllers\Admin\Configuracao\ConfiguracaoController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\ProdutoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste', function () {

    return false;

});

Route::prefix('auth')->name('auth.')->group(function () {

    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/logar',[AuthController::class,'logar'])->name('logar');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});


/**
 * Rotas autenticadas
 */

//Route::get('admin/clientes/buscarpornome/{nome}', [ClienteController::class,'getClientesPorNome'])->name('admin.clientes.buscarpornome');

Route::middleware(['auth'])->group(function(){

    Route::get('/admin',[HomeController::class,'index'])->name('acessoexterno');

    Route::prefix('admin')->name('admin.')->group(function () {

        //Clientes
        Route::get('clientes/datatables', [ClienteController::class,'datatables'])->name('clientes.datatables');
        Route::get('clientes/buscarpornome/{nome}', [ClienteController::class,'getClientesPorNome'])->name('clientes.buscarpornome');
        Route::resource("/clientes" , ClienteController::class);

        //Produtos
        Route::get('produtos/datatables', [ProdutoController::class,'datatables'])->name('produtos.datatables');
        Route::get('produtos/buscarpornome/{nome}', [ProdutoController::class,'getProdutosPorNome'])->name('produtos.buscarpornome');
        Route::resource("/produtos" , ProdutoController::class);

        //pedidos
        Route::get('pedidos/datatables', [PedidoController::class,'datatables'])->name('pedidos.datatables');
        Route::resource("/pedidos" , PedidoController::class);

        //Configurações
        Route::prefix('configuracao')->name('configuracao.')->group(function () {

            Route::get('/acessosexterno',[ConfiguracaoController::class,'index'])->name('acessoexterno');
            Route::post('/concessaosenha',[ConcessaoClientOauthController::class,'habilitarConcessaoSenhaClient'])->name('concessaosenha');
        });
    });
});
