<!doctype html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="{{asset('bootstrap/v5/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- datatable -->
    <link rel="stylesheet" href="{{asset('plugins/datatable/dataTables.bootstrap4.min.css')}}">

    <!-- auto-complete -->
    <link rel="stylesheet" href="{{asset('plugins/autocomplete/jquery-ui.css')}}">

    @yield('css')

    <title>{{env('APP_NAME')}}</title>

  </head>
  <body class="bg-light">

    <div class="row">

        <div class="col-md-12">

            @if(Auth::check())

                <nav class="navbar navbar-expand-lg navbar-dark bg-success">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{url('/admin')}}">Silas Sena</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">

                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{url('/admin')}}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{url('/admin/clientes')}}">Clientes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{url('/admin/produtos')}}">Produtos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{url('/admin/pedidos')}}">Pedidos</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Configurações
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="{{url('admin/configuracao/acessosexterno')}}">Integrações (OAUTH 2)</a></li>
                                        <li><a class="dropdown-item" href="{{url('auth/logout')}}">Sair</a></li>
                                    </ul>
                                </li>

                            </ul>

                        </div>
                    </div>
                </nav>
            @endif

        </div>

    </div>

    <div class="row">

        <div class="col-12">
            <div class="container pt-2">

                @yield('conteudo')

            </div>
        </div>

    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{asset('bootstrap/v5/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('jquery/jquery-3.6.0.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/sweetalert2011.js')}}"></script>
    <script src="{{asset('js/helper.js')}}"></script>

    <!-- datatable -->
    <script src="{{asset('plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>

    <!-- auto-complete -->
    <script src="{{asset('plugins/autocomplete/jquery-ui.js')}}"></script>


    @yield('js')

  </body>

</html>
