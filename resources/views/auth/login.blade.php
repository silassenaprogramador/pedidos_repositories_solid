<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{asset('bootstrap/v5/css/bootstrap.min.css')}}" rel="stylesheet">

    <style>
        #bx_login{ margin-top: 25%;}
    </style>

    <title>{{env('APP_NAME')}}</title>
  </head>
  <body>

    <div class="row">
        <div class="col-6">

            <div class="container">

                <div class="row justify-content-center">
                    <div id="bx_login"class="col-lg-6 col-sm-12">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{url('auth/logar')}}" method="POST">
                            @CSRF
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                <small class="form-text"></small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Logar</button>
                        </form>

                    </div>
                </div>

            </div>

        </div>

        <div class="col-6" >

            <div class="p-5 mb-4 bg-light rounded-3" style=" margin-top: 10%;">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Projeto em branco</h1>
                    <p class="col-md-8 fs-4">Base para iniciar qualquer projeto em laravel 8</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{asset('bootstrap/v5/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('jquery/jquery-3.6.0.min.js')}}"></script>

  </body>
</html>


