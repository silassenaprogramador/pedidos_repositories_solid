@extends('layouts.admin.home')

@section('css')


@endsection

@section('conteudo')

    <div class="row">
        <div class="col-12">

            <button type="button" class="btn btn-success" id="bt_cadastrar">Novo</button>

        </div>
    </div>

    <div class="row pt-3">
        <div class="col-12">

            <div class="card">

                <div class="card-header">
                     <h5>Clientes</h5>
                </div>

                <div class="card-box p-2">

                    <table id="tb_cliente" class="table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>Bairro</th>
                                <th>Bairro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>


    <div class="row pt-3">
        <div class="col-12">

            <div id="modalRegistro" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="card">
                            <div class="card-header">
                                <h3>Cliente</h3>
                            </div>
                            <div class="card-body">

                                <form id="formRegistro">

                                    <input type="hidden" id="id" name="id">

                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="texto" class="form-control" id="nome" name="nome" placeholder="Digite Nome">
                                        <small id="sm_nome"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="texto" class="form-control" id="email" name="email" placeholder="Digite Email">
                                        <small id="sm_email"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="telefone">Telefone</label>
                                        <input type="texto" class="form-control" id="telefone" name="telefone" placeholder="Digite Telefone">
                                        <small id="sm_telefone"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="nome">Cidade</label>
                                        <input type="texto" class="form-control" id="cidade" name="cidade" placeholder="Digite Cidade">
                                        <small id="sm_cidade"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="texto" class="form-control" id="bairro" name="bairro" placeholder="Digite Bairro">
                                        <small id="sm_bairro"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="numero">Numero</label>
                                        <input type="texto" class="form-control" id="numero" name="numero" placeholder="Digite Numero">
                                        <small id="sm_numero"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="texto" class="form-control" id="cidade" placeholder="Digite Cidade">
                                        <small id="sm_cidade"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="uf">Estado</label>
                                        <input type="texto" class="form-control" id="uf" name="uf" placeholder="Digite Estado">
                                        <small id="sm_uf"></small>
                                    </div>

                                    <button type="button" id="bt_salvar" class="btn btn-success mt-2">Salvar</button>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')

    <script>

        function init(){

            return true;
        }

        async function salvarRegistro(){

            limparValidacoesForm('formRegistro');

            try{

                let link = "{{ url('admin/clientes') }}";
                let dados_salvar = $('#formRegistro').serialize();

                await requestAjax(link, dados_salvar);

                alert_message("Registro cadastrado com sucesso!");

            }catch(e){

                if(e.status == 422){

                    $.each(e.responseJSON,function(campo,valor){
                        formatarValidacao(campo,valor);
                    });

                    return;
                }

                alert_message(e.responseText,"error");
            }
        }

         async function atualizarRegistro(){

            limparValidacoesForm('formRegistro');

            try{

                let id = $('#formRegistro #id').val();
                let link = "{{ url('admin/clientes') }}" +"/"+ id;
                let dados_atualizar = $('#formRegistro').serialize()+"&_method=PUT";

                await requestAjax(link, dados_atualizar);

                alert_message("Registro atualizado com sucesso!");

                carregaDados();

            }catch(e){

                if(e.status == 422){

                    $.each(e.responseJSON,function(campo,valor){
                        formatarValidacao(campo,valor);
                    });

                    return;
                }

                alert_message(e.responseText,"error");
            }
        }

        async function editar(id){

            limparValidacoesForm('formRegistro');

            let link = "{{ url('admin/clientes') }}" + "/" + id;

            let dados = await requestAjax(link, [], 'GET');

            carregaForm(dados);

        }

        function carregaForm(dados){

            $('#formRegistro')[0].reset();

            $.each(dados,function(campo,valor){

                $(`#formRegistro #${campo}`).val(valor);
            });

            $('#modalRegistro').modal('show');
        }

        function carregaDados(){

            if($('#tb_cliente').DataTable()) $('#tb_cliente').DataTable().destroy();

            $('#tb_cliente').DataTable({
                processing:true,
                serverSide: true,
                searching: true,
                pageLength: 10,
                language: {
                "url": "{{asset('json/Portuguese-Brasil.json')}}"
                },
                ajax:{
                    url:"{!! route('admin.clientes.datatables') !!}",
                    error: function (xhr, error, code){
                        helper_swall_message('Ocorreu um erro!',xhr.responseJSON,'error');
                    }
                },
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'nome', name: 'nome'},
                    { data: 'email', name: 'email'},
                    { data: 'telefone', name: 'telefone'},
                    { data: 'rua', name: 'rua'},
                    { data: 'bairro', name: 'bairro'},
                    { data: 'cidade', name: 'cidade'},
                    { data: 'uf', name: 'uf'},
                    { data: 'action', name: 'action'}
                ]
            });
        }

        async function deletar(id){

            try{

                let link = "{{ url('admin/clientes') }}" + "/" + id;

                let dados = await requestAjax(link, '_method=DELETE');

                alert_message("Registro remvido com sucesso!");

                carregaDados();

            }catch(e){

                alert_message(e.responseText,"error");
            }

        }

        $(()=>{

            init();

            carregaDados();

            $('#bt_cadastrar').click(()=>{

                $('#formRegistro')[0].reset();
                $('#modalRegistro').modal('show');
            });

            $('#bt_salvar').click(()=>{

                if($('#formRegistro #id').val() == ""){

                    salvarRegistro();

                }else{

                    atualizarRegistro();
                }

            });

        });

    </script>

@endsection
