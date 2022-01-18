function alert_message(message, icon = `success`) {

    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

    Toast.fire({
        icon: icon,
        title: message
    });
}


async function requestAjax(link, dados = [], method = 'Post'){

    return await $.ajax({
            url: link,
            method: method,
            dataType:'Json',
            data: dados,
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
}

function formatarValidacao(campo,valor){

    $(`#${campo}`).css({'border-color':'red'});
    $(`#sm_${campo}`).text(valor);
    $(`#sm_${campo}`).css({'color': 'red'});
}

function limparValidacoesForm(id_form){

    $(`#${id_form} small`).html("");

    $.each($(`#${id_form}`).find("input"),function(i,v){
        $(v).css({'border-color':'#ced4da'});
    });

}

/**
 *
 * @param {Json de uma collection paraginada pelo laravel} data
 */
function montarPaginacao(data){

    let links = '';

    $.each(data.links,function(key,item){

        let ativo = "";

        if(item.active == true){
            ativo = 'active';
        }

        links += `<li class="page-item ${ativo}"><a class="page-link" href="${item.url ?? '#'}">${item.label}</a></li>`;
    });

    return `<nav>
                <ul class="pagination">
                    ${links}
                </ul>
            </nav>`;
}

