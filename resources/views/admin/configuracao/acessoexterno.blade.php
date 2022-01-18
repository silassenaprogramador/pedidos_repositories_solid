@extends('layouts.admin.home')

@section('css')


@endsection

@section('conteudo')

    <div class="row">
        <div class="col-12">
            <div class="card mt-5">

                <div class="card-header">
                    <button id="bt_abrir_modal_cadastrar_cliente" class="btn btn-success rigth">novo</button>
                </div>

                <div class="card-body">

                    <table class="table" id="tb_oauth_clients">
                        <thead>
                            <tr>
                                <th scope="col">ID CLIENTE</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">SECRET</th>
                                <th scope="col">REDIRECT</th>
                                <th scope="col">HABILITADO</th>
                                <th scope="col">ALTERAR</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <!-- modal de cadastro de clientes -->
    <div class="row">

        <div id="modal_cadastrar_cliente_oauth" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="card">

                        <div class="card-header">
                            <h4>Cadastrar clientes</h4>
                        </div>

                        <div class="card-body">

                            <form id="form_cliente_oauth">

                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                    <small id="small_name" class="form-text text-muted"></small>
                                </div>

                                <div class="form-group">
                                    <label for="redirect">Link Redirecionamento</label>
                                    <input type="text" class="form-control" id="redirect" name="redirect">
                                    <small id="small_redirect" class="form-text text-muted"></small>
                                </div>
                            </form>

                        </div>

                        <div class="card-footer">

                            <button id="bt_cadastrar_cliente_oauth" class="btn btn-success">Salvar cliente</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>


        async function listar_clientes(){

            let rows = ``;

            let config_busca = {
                url:`/oauth/clients`
            };

            let lista_clientes =  await $.ajax(config_busca);

            $.each(lista_clientes, (index,value)=>{
                rows += `
                    <tr>
                        <td>${value.id}</td>
                        <td>${value.name}</td>
                        <td>${value.secret}</td>
                        <td>${value.redirect}</td>
                        <td>${value.password_client}</td>
                        <td>
                            <a href='javascript:;' onclick="habilitar_autenticacao_por_senha('${value.id}')"><i class="fa fa-check-square fa-2x text-success" ></i></a>
                            <a href='javascript:;' onclick="remover_cliente('${value.id}')"><i class="fa fa-trash fa-2x text-danger" ></i></a>
                        </td>
                    </tr>
                `;
            });

            $('#tb_oauth_clients tbody').html(rows);
        }


        async function salvar_cliente_oauth(){

            limpar_validacao_formulario();

            let dados = {
                    name: $('#form_cliente_oauth #name').val(),
                    redirect: $('#form_cliente_oauth #redirect').val(),
                    password_client : "true"
                };

            let request = {
                    url:`/oauth/clients`,
                    type:"POST",
                    dataType: 'json',
                    data:dados,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    statusCode: {
                        201: function(xhr) {
                            alert_message("Cliente habilitado com sucesso!");
                            fecharModal();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){

                        //campos invalidos
                        if(jqXHR.status == 422){

                            let list_errors = jqXHR.responseJSON.errors;

                            $.each(list_errors,(index,value)=>{

                                exibe_campos_invalidos(index, value);
                            });
                        }

                    }
                };

            await $.ajax(request);
        }


        async function habilitar_autenticacao_por_senha(id_client){

            Swal.fire({
                title: 'Habilitar cliente',
                text: "Tem certeza que deseja habilitar esse cliente a fazer concessão de senha?",
                icon: 'Atenção',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then(async (result) => {

                if (result.isConfirmed) {

                    await $.ajax({
                        url:`{{ url('admin/configuracao/concessaosenha') }}`,
                        type:"POST",
                        dataType: 'json',
                        data:{
                            id:id_client
                        },
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(data){

                            alert_message("Cliente habilitado com sucesso!");
                            listar_clientes();

                        },
                        error: function(data, textStatus, errorThrown){

                            alert_message(errorThrown,'error');
                        }
                    });
                }
            });

        }


        async function remover_cliente(id_client){

            Swal.fire({
                title: 'Remover cliente',
                text: "Tem certeza que deseja habilitar esse cliente a fazer concessão de senha?",
                icon: 'Atenção',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then(async (result) => {

                if (result.isConfirmed) {

                    await $.ajax({
                        url:`/oauth/clients/${id_client}`,
                        type:"DELETE",
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(data){

                            alert_message("Cliente removido com sucesso!");
                            listar_clientes();

                        },
                        error: function(data, textStatus, errorThrown){

                            alert_message(errorThrown,'error');
                        }
                    });
                }
            });

        }


        function limpar_validacao_formulario(){

            $("#form_cliente_oauth").find("input").css({'border-color':'#ccc'});
            $("#form_cliente_oauth").find("small").html("");
        }

        function exibe_campos_invalidos(campo, erro){

            $(`#form_cliente_oauth #${campo}`).css({'border-color':'red'});
            $(`#form_cliente_oauth #small_${campo}`).html(erro);
        }

        /**
         *
         */
        function fecharModal(){

            $('#form_cliente_oauth')[0].reset();
            $("#modal_cadastrar_cliente_oauth").modal('hide');
            listar_clientes();
        }



        function init(){

            listar_clientes();
        }

        $(()=>{

            init();

            $('#bt_abrir_modal_cadastrar_cliente').click(()=>{

                $('#modal_cadastrar_cliente_oauth').modal('show');
            });

            $('#bt_cadastrar_cliente_oauth').click(()=>{

                salvar_cliente_oauth();
            });

        });

    </script>

@endsection
