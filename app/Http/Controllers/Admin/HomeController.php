<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function index(){

        return view('admin.index');
    }
}
