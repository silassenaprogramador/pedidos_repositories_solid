<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private $redirectToUrl = "/admin";

    /**
     *
     */
    function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     *
     */
    public function login(){

       return view('auth.login');
    }

    /**
     *
     */
    public function logar(Request $request){

        try{

            $campos = $request->only(['email','password']);

            $validar = helpers_validar_campos($campos,$this->user->rules,$this->user->menssagens);

            if($validar['status'] == 422){

                return redirect()->back()->withErrors($validar['response'])->withInput();
            }

        if (Auth::attempt($campos)) {

            return redirect($this->redirectToUrl);
        }

        return redirect()->back()->withErrors("Usuario não encontrado!")->withInput();

        }catch(Exception $e){

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     *
     */
    public function logout(){

        Auth::logout();

        return redirect($this->redirectToUrl);
    }

}


