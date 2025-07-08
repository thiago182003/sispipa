var dataTable;

document.addEventListener("DOMContentLoaded", function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name='_token']").val()
        }
    });

    let table = document.querySelector(".datatables-descontos");
    dataTable = new DataTable(table, {
        ajax: "/e1/descontoemferias/getall",
        columns: [
            { data: "militar.pg_nome" },
            { data: "qtd_dias" },
            { 
                data: "diex_numero",
                render: function(data, type, row) {
                    if (row.diex_arquivo) {
                        return `<a href="/e1/descontoemferias/download/${row.id}" target="_blank">${data}</a>`;
                    }
                    return data;
                }
            },
            { data: "anoreferencia" },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <div class="d-flex align-items-center">
                            <a href="javascript:editar(${row.id})" class="btn btn-icon"><i class="bx bx-edit icon-md"></i></a>
                            <a href="javascript:deletar(${row.id})" class="btn btn-icon"><i class="bx bx-trash icon-md deletar"></i></a>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#militar_id').select2({
        dropdownParent: $('#modalDescontoFerias')
    });

    $('#form-desconto').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '/e1/descontoemferias/store',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#modalDescontoFerias').modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Sucesso",
                    text: response.message,
                    customClass: { confirmButton: "btn btn-success" }
                });
                dataTable.ajax.reload();
                $('#form-desconto')[0].reset();
            },
            error: function (xhr) {
                let msg = "Erro ao salvar.";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join("\n");
                }
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: msg,
                    customClass: { confirmButton: "btn btn-danger" }
                });
            }
        });
    });
});

function editar(id) {
    $.post('/e1/descontoemferias/show', { id: id }, function (data) {
        $('#modalDescontoFerias').modal('show');
        $('#id').val(data.id);
        $('#militar_id').val(data.militar_id).trigger('change');
        $('#qtd_dias').val(data.qtd_dias);
        $('#diex_numero').val(data.diex_numero);
        $('#anoreferencia').val(data.anoreferencia);
    });
}

function deletar(id) {
    Swal.fire({
        title: "Tem certeza que deseja deletar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, deletar",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-label-secondary"
        },
        buttonsStyling: false
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            $.post('/e1/descontoemferias/delete', { id: id }, function (resposta) {
                Swal.fire({
                    icon: "success",
                    title: "Deletado",
                    text: resposta.message,
                    customClass: { confirmButton: "btn btn-success" }
                });
                dataTable.ajax.reload();
            }).fail(() => {
                Swal.fire({
                    icon: "error",
                    title: "Erro ao deletar",
                    text: "Ocorreu um erro ao tentar excluir o registro.",
                    customClass: { confirmButton: "btn btn-danger" }
                });
            });
        }
    });
}