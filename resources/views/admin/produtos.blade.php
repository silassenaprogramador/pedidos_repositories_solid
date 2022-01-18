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
                     <h5>Produtos</h5>
                </div>

                <div class="card-box p-2">

                    <table id="tb_produto" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produto</th>
                                <th>Valor</th>
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
                                <h3>Produto</h3>
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
                                        <label for="valor">Email</label>
                                        <input type="texto" class="form-control" id="valor" name="valor" placeholder="Digite Valor">
                                        <small id="sm_valor"></small>
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

                let link = "{{ url('admin/produtos') }}";
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
                let link = "{{ url('admin/produtos') }}" +"/"+ id;
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

            let link = "{{ url('admin/produtos') }}" + "/" + id;

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

            if($('#tb_produto').DataTable()) $('#tb_produto').DataTable().destroy();

            $('#tb_produto').DataTable({
                processing:true,
                serverSide: true,
                searching: true,
                pageLength: 10,
                language: {
                "url": "{{asset('json/Portuguese-Brasil.json')}}"
                },
                ajax:{
                    url:"{!! route('admin.produtos.datatables') !!}",
                    error: function (xhr, error, code){
                        helper_swall_message('Ocorreu um erro!',xhr.responseJSON,'error');
                    }
                },
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'nome', name: 'nome'},
                    { data: 'valor', name: 'valor'},
                    { data: 'action', name: 'action'}
                ]
            });
        }

        async function deletar(id){

            try{

                let link = "{{ url('admin/produtos') }}" + "/" + id;

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
