@extends('layouts.admin.home')

@section('css')

    <style>

        #list_clientes{
            overflow-y: scroll;
            position: absolute;
            width: 60%;
            max-height: 200px;
            z-index: 10;
            border-radius: 0px 0px 10px 10px;
        }

        #list_produtos{
            overflow-y: scroll;
            position: absolute;
            width: 60%;
            max-height: 200px;
            z-index: 10;
            border-radius: 0px 0px 10px 10px;
        }

    </style>

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
                     <h5>Pedidos</h5>
                </div>

                <div class="card-box p-2">

                    <table id="tb_pedido" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Status</th>
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
                                <h3>Pedido</h3>
                                <label for="" id="display_valor_total"></label>
                            </div>
                            <div class="card-body">

                                <form id="formRegistro">

                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="cliente_id" name="cliente_id">
                                    <input type="hidden" id="valor_total" name="valor_total">

                                    <div class="form-group">
                                        <label for="cliente">Cliente</label>
                                        <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Digite Nome">
                                        <small id="sm_cliente"></small>
                                        <div id="list_clientes"></div>
                                    </div>

                                    <fieldset class="form-group">

                                        <legend>Produtos</legend>

                                        <div class="header-produtos row">

                                            <input type="hidden" name="produto_id" id="produto_id">

                                            <div class="form-group col-lg-7">
                                                <label for="produto">Produto</label>
                                                <input type="text" class="form-control" id="nome_produto" name="nome_produto">
                                                <div id="list_produtos"></div>
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="quantidade">quantidade</label>
                                                <input type="text" class="form-control" id="quantidade" name="quantidade">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="valor">valor</label>
                                                <input type="text" class="form-control" id="valor" name="valor">
                                            </div>

                                            <div class="form-group col-lg-1 pt-4">
                                                <button type="button" class="btn btn-success" onclick="addProduto()"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div>

                                        <div class="lista_produtos">

                                        </div>

                                    </fieldset>

                                </form>

                            </div>

                            <div class="card-footer">

                                <button type="button" class="btn btn-success" onclick="addProduto($(this))"><i class="fa fa-plus"></i></button>
                                <button type="button" id="bt_salvar" class="btn btn-success">Salvar</button>


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

        function delProduto(el){

            $(el).parent().parent().remove();

            atualizaTotalGeral();
        }

        function addProduto(){

            let produto_id = $("#produto_id").val();
            let nome_produto = $("#nome_produto").val();
            let quantidade = $("#quantidade").val();
            let valor = $("#valor").val();
            let total = quantidade * valor;

            montarLinhaProduto(produto_id, nome_produto, quantidade, valor, total);
        }


        function montarLinhaProduto(produto_id, nome_produto, quantidade, valor, total){

            let row_produto = `<div class="row-produtos row">
                                    <input type="hidden" name="produto_id[]" value="${produto_id}">
                                    <div class="form-group col-lg-5">
                                        <label for="produto">Produto</label>
                                        <input type="text" class="form-control produto" name="produto[]" value="${nome_produto}" readonly>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="quantidade">quantidade</label>
                                        <input type="text" class="form-control" name_prop="quantidade" name="quantidade[]" value="${quantidade}" onfocusout="atualizaTotal($(this))">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="valor">valor</label>
                                        <input type="text" class="form-control" name_prop="valor" name="valor[]" value="${valor}" onfocusout="atualizaTotal($(this))">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="valor">Total</label>
                                        <input type="text" class="form-control" name_prop="total" name="total[]" value="${total}"readonly>
                                    </div>
                                    <div class="form-group col-lg-1 pt-4">
                                        <button type="button" class="btn btn-danger" onclick="delProduto($(this))"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>`;

            $('.lista_produtos').append(row_produto);

            atualizaTotalGeral();
        }


        function atualizaTotal(el){

            let el_quantidade;
            let el_valor;
            let el_total;

            let row_produto = $(el).parent().parent();

            $.each(row_produto, function(i,blocos){

                $.each($(blocos).children(), function(i,bloco){

                    $.each($(bloco).children(), function(i,campo){

                        if($(campo).attr("name_prop") == 'quantidade')
                            el_quantidade = $(campo);

                        if($(campo).attr("name_prop") == 'valor')
                            el_valor = $(campo);

                        if($(campo).attr("name_prop") == 'total')
                            el_total = $(campo);

                    });
                });
            });

            let quantidade = parseFloat($(el_quantidade).val());
            let valor = parseFloat($(el_valor).val());
            let sub_total = quantidade * valor;
            let sub_total_formatado = sub_total.toFixed(2);

            $(el_total).val( sub_total_formatado );

            atualizaTotalGeral();
        }

        function atualizaTotalGeral(){

            let total_geral = 0;

            $.each($('.lista_produtos').find('.row-produtos'), function(i,row_produtos){

                $.each($(row_produtos).find('.form-group'), function(i,form_group){

                    $.each($(form_group).children(), function(i,campo){

                        if($(campo).attr("name_prop") == 'total'){

                            total_geral  += parseFloat($(campo).val());
                        }
                    });
                });
            });

            let total_geral_formatado = total_geral.toFixed(2);

            $('#display_valor_total').html(total_geral_formatado);
            $('#valor_total').val(total_geral_formatado);

        }

        async function salvarRegistro(){

            limparValidacoesForm('formRegistro');

            try{

                let link = "{{ url('admin/pedidos') }}";
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
                let link = "{{ url('admin/pedidos') }}" +"/"+ id;
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

            let link = "{{ url('admin/pedidos') }}" + "/" + id;

            let dados = await requestAjax(link, [], 'GET');

            carregaForm(dados);

        }

        function carregaForm(dados){

            $('#formRegistro')[0].reset();

            $("#formRegistro #id").val(dados.id);
            $("#formRegistro #cliente_id").val(dados.cliente.id);
            $("#formRegistro #cliente").val(dados.cliente.nome);

            $(".lista_produtos").html("");

            $.each(dados.item_pedido,function(key,value){

                montarLinhaProduto(value.produto_id, value.nome, value.quantidade, value.valor, value.valor_total);
            });


            $('#modalRegistro').modal('show');
        }

        function carregaDados(){

            if($('#tb_pedido').DataTable()) $('#tb_pedido').DataTable().destroy();

            $('#tb_pedido').DataTable({
                processing:true,
                serverSide: true,
                searching: true,
                pageLength: 10,
                language: {
                "url": "{{asset('json/Portuguese-Brasil.json')}}"
                },
                ajax:{
                    url:"{!! route('admin.pedidos.datatables') !!}",
                    error: function (xhr, error, code){
                        helper_swall_message('Ocorreu um erro!',xhr.responseJSON,'error');
                    }
                },
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'cliente.nome', name: 'cliente.nome'},
                    { data: 'status', name: 'status'},
                    { data: 'valor_total', name: 'valor_total'},
                    { data: 'action', name: 'action'}
                ]
            });
        }

        async function deletar(id){

            try{

                let link = "{{ url('admin/pedidos') }}" + "/" + id;

                let dados = await requestAjax(link, '_method=DELETE');

                alert_message("Registro remvido com sucesso!");

                carregaDados();

            }catch(e){

                alert_message(e.responseText,"error");
            }

        }

        function selecionarCliente(id,value){

            $("#cliente_id").val(id);
            $("#cliente").val(value);
            $("#list_clientes").hide();
        }

        function selecionarProduto(id,nome_produto,valor){

            $("#produto_id").val(id);
            $("#nome_produto").val(nome_produto);
            $("#quantidade").val(1);
            $("#valor").val(valor);

            $("#list_produtos").hide();
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

            $('#cliente').autocomplete({

                source: function(request,response){

                    $.ajax({
                        url:"{{ url('admin/clientes/buscarpornome') }}" +"/"+ $('#cliente').val(),
                        type: "get",
                        dataType :"Json",
                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            "nome":request.term
                        },
                        success:function(result){

                            let item_lista = "";

                            $.each(result.data,function(key,value) {
                                item_lista += `<a href="javascript:;" onclick="selecionarCliente('${value.id}','${value.nome}')" class="list-group-item list-group-item-action">${value.nome}</a>`;
                            });

                            item_lista = `<ul class="list-group">${item_lista}</ul>`;

                            $('#list_clientes').html(item_lista);

                            $("#list_clientes").show();

                        }
                    });
                }
            });


            $('#nome_produto').autocomplete({

                source: function(request,response){

                    $.ajax({
                        url:"{{ url('admin/produtos/buscarpornome') }}" +"/"+ $('#nome_produto').val(),
                        type: "get",
                        dataType :"Json",
                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            "nome":request.term
                        },
                        success:function(result){

                            let item_lista = "";

                            $.each(result.data,function(key,value) {
                                item_lista += `<a href="javascript:;" onclick="selecionarProduto('${value.id}','${value.nome}','${value.valor}')" class="list-group-item list-group-item-action">${value.nome}</a>`;
                            });

                            item_lista = `<ul class="list-group">${item_lista}</ul>`;

                            $('#list_produtos').html(item_lista);

                            $("#list_produtos").show();

                        }
                    });
                }
            });

        });

    </script>

@endsection
