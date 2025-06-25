var dataTable;
var myOffcanvas = document.getElementById('offcanvasAddUser');

document.addEventListener("DOMContentLoaded", function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name='_token']").val()
        }
    });

  

    let table = document.querySelector(".datatables-users");
    dataTable = new DataTable(table, {
        ajax: "/administrativo/getplanodeferias",
        columns: [
            { data: "militar.pg_nome" },
            { data: "qtdparcelas" },
            { data: "periodo1" },
            { data: "periodo2" },
            { data: "periodo3" },
            { data: "Ações" }
        ],
        columnDefs: [
            {
                targets: -1,
                title: "Ações",
                searchable: !1,
                orderable: !1,
                render: (data, type, row, meta) => `
                    <div class="d-flex align-items-center">
                        <a href='javascript:confirmarExclusao(${row.id});' class="btn btn-icon">
                            <i class="icon-base bx bx-trash icon-md deletar"></i>
                        </a>
                        <a href='javascript:editar(${row.id});' class="btn btn-icon">
                            <i class="icon-base bx bx-edit icon-md"></i>
                        </a>
                    </div>
                `
            }
        ],
        layout: {
            topStart: {
                rowClass: "row mx-3 my-0 justify-content-between",
                features: [{
                    pageLength: {
                        menu: [10, 25, 50, 100],
                        text: "_MENU_"
                    }
                }]
            },
            topEnd: {
                features: [{
                    search: {
                        placeholder: "Buscar",
                        text: "_INPUT_"
                    }
                }, {
                    buttons: [{
                        text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Adicionar Plano</span>',
                        className: "add-new btn btn-primary",
                        attr: {
                            "data-bs-toggle": "offcanvas",
                            "data-bs-target": "#offcanvasAddUser"
                        }
                    }]
                }]
            },
            bottomStart: {
                rowClass: "row mx-3 justify-content-between",
                features: ["info"]
            },
            bottomEnd: {
                paging: {
                    firstLast: !1
                }
            }
        },
        language: {
            sLengthMenu: "_MENU_",
            search: "",
            searchPlaceholder: "Buscar usuário",
            paginate: {
                next: '<i class="icon-base bx bx-chevron-right icon-18px"></i>',
                previous: '<i class="icon-base bx bx-chevron-left icon-18px"></i>'
            }
        },
        responsive: {
            details: {
                display: DataTable.Responsive.display.modal({
                    header: function (e) {
                        return "Details of " + e.data().militar.pg_nome
                    }
                }),
                type: "column",
                renderer: function (e, t, a) {
                    var s, n, o, a = a.map(function (e) {
                        return "" !== e.title ? `<tr data-dt-row="${e.rowIndex}" data-dt-column="${e.columnIndex}">
                    <td>${e.title}:</td>
                    <td>${e.data}</td>
                    </tr>` : ""
                    }).join("");
                    return !!a && ((s = document.createElement("div")).classList.add("table-responsive"),
                        n = document.createElement("table"),
                        s.appendChild(n),
                        n.classList.add("table"),
                        (o = document.createElement("tbody")).innerHTML = a,
                        n.appendChild(o),
                        s)
                }
            }
        },
        initComplete: function () {
            let r = this.api();
        }
    });
        document.addEventListener("show.bs.modal", function (e) {
            e.target.classList.contains("dtr-bs-modal") && l()
        }),
        document.addEventListener("hide.bs.modal", function (e) {
            e.target.classList.contains("dtr-bs-modal") && l()
        }),
        $(".dt-buttons > .btn-group > button").removeClass("btn-secondary")
    setTimeout(() => {
        [{
            selector: ".dt-buttons .btn",
            classToRemove: "btn-secondary"
        }, {
            selector: ".dt-search .form-control",
            classToRemove: "form-control-sm"
        }, {
            selector: ".dt-length .form-select",
            classToRemove: "form-select-sm",
            classToAdd: "ms-0"
        }, {
            selector: ".dt-length",
            classToAdd: "mb-md-6 mb-0"
        }, {
            selector: ".dt-search",
            classToAdd: "mb-md-6 mb-2"
        }, {
            selector: ".dt-layout-end",
            classToRemove: "justify-content-between",
            classToAdd: "d-flex gap-md-4 justify-content-md-between justify-content-center gap-4 flex-wrap mt-0"
        }, {
            selector: ".dt-layout-start",
            classToAdd: "mt-0"
        }, {
            selector: ".dt-buttons",
            classToAdd: "d-flex gap-4 mb-md-0 mb-6"
        }, {
            selector: ".dt-layout-table",
            classToRemove: "row mt-2"
        }, {
            selector: ".dt-layout-full",
            classToRemove: "col-md col-12",
            classToAdd: "table-responsive"
        }].forEach(({ selector: e, classToRemove: a, classToAdd: s }) => {
            document.querySelectorAll(e).forEach(t => {
                a && a.split(" ").forEach(e => t.classList.remove(e)),
                    s && s.split(" ").forEach(e => t.classList.add(e))
            }
            )
        }
        )
    }
        , 100);
    
    
    
    
        FormValidation.formValidation(document.getElementById('form-secao'), {
        fields: {
            nome: {
                validators: {
                    notEmpty: {
                        message: "Preencha um nome"
                    }
                }
            },
            sigla: {
                validators: {
                    notEmpty: {
                        message: "Preencha uma sigla"
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger,
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: "",
                rowSelector: function (e, t) {
                    return ".form-control-validation"
                }
            }),
            submitButton: new FormValidation.plugins.SubmitButton,
            autoFocus: new FormValidation.plugins.AutoFocus
        }
    }).on('core.form.valid', function () {
        $.post('/e1/planodeferias/store', {
            id: id.value,
            p1inicio: p1inicio.value,
            p1fim: p1fim.value,
            p2inicio: p2inicio.value,
            p2fim: p2fim.value,
            p3inicio: p3inicio.value,
            p3fim: p3fim.value,
            anoreferencia: anoreferencia.value,
            qtdparcelas: qtdparcelas.value,
            militar_id: selMilitar.value
        }).done(function (response) {
            Swal.fire({
                icon: "success",
                title: "Inserido",
                text: "Plano salvo com sucesso!",
                customClass: { confirmButton: "btn btn-success" }
            }).then(() => {
                location.reload();
            });
        }).fail(function(error){
            Swal.fire({
                icon: "error",
                title: "Erro ao salvar",
                text: "Ocorreu um erro ao tentar salvar o plano.",
                customClass: { confirmButton: "btn btn-danger" }
            });
        });

    });
    
    myOffcanvas.addEventListener('show.bs.offcanvas', function () {
        $("#id").val("");
        $("#p1inicio").val("");
        $("#p1fim").val("");
        $("#p2inicio").val("");
        $("#p2fim").val("");
        $("#p3inicio").val("");
        $("#p3fim").val("");
        $("#anoreferencia").val("");
        $("#qtdparcelas").val("");
        $("#selMilitar").val("");
        $("#selMilitar").change();
    });

    
});

function editar(id){
    $.ajax({
        url: '/e1/planodeferias/show',
        method: 'POST',
        data: {
            id: id,
        },
        success: function (response) {
            console.log(response);
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
            bsOffcanvas.show();
            $("#id").val(response.id);
            $("#p1inicio").val(response.p1inicio);
            $("#p1fim").val(response.p1fim);
            $("#p2inicio").val(response.p2inicio);
            $("#p2fim").val(response.p2fim);
            $("#p3inicio").val(response.p3inicio);
            $("#p3fim").val(response.p3fim);
            $("#anoreferencia").val(response.anoreferencia);
            $("#qtdparcelas").val(response.qtdparcelas);
            $("#selMilitar").val(response.militar_id);
            $("#selMilitar").change();
        },
        error: function (xhr) {
            console.error('Erro ao buscar plano.', xhr);
        }
    });
    
}

function confirmarExclusao(id) {

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
            
            if (!id) {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "ID da Seção não encontrado!",
                    customClass: { confirmButton: "btn btn-danger" }
                });
                return;
            }

            // Faz a requisição AJAX para deletar a instituição
            $.post('/e1/planodeferias/delete', { id: id })
                .done((resposta) => {
                    Swal.fire({
                        icon: "success",
                        title: "Deletado",
                        text: "O dado foi deletado com sucesso!",
                        customClass: { confirmButton: "btn btn-success" }
                    }).then(() => {
                        location.reload();
                    });
                })
                .fail(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Erro ao deletar",
                        text: "Ocorreu um erro ao tentar excluir a seção.",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                });
        }
    });
}

$(document).ready(function() {
    $("#selMilitar").select2({
        placeholder: "Selecione um militar",
        allowClear: true,
        dropdownParent: $("#offcanvasAddUser") // Troque pelo ID do seu offcanvas
    });
});