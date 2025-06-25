var dataTable;

$(document).ready(function () {
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 00000-0000');
});

document.addEventListener("DOMContentLoaded", function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name='_token']").val()
        }
    });

    let table = document.querySelector(".datatables-users");
    dataTable = new DataTable(table, {
        ajax: "/administrativo/militares/getall",
        columns: [
            { data: ["nomeguerra","postoGraduacao"] },
            { data: "nome" },
            { data: "secao" },
            { data: "Ações" }
        ],
        columnDefs: [
            {
                targets: 0,
                responsivePriority: 3,
                render: function (data, type, row, meta) {
                    var nome =  row.nomeguerra;
                    var imagem = row.img;
                    return `
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-sm me-4">
                                        
                                        ${imagem 
                                            ? `<img src="${assetsPath}img/avatars/${imagem}" alt="Avatar" class="rounded-circle">`
                                            : (() => {
                                                const initials = (nome.match(/\b\w/g) || []).map(e => e.toUpperCase());
                                                const avatarText = (initials.shift() || '') + (initials.pop() || '');
                                                const colors = ["success", "danger", "warning", "info", "dark", "primary", "secondary"];
                                                const bgColor = colors[Math.floor(Math.random() * colors.length)];
                                                return `<span class="avatar-initial rounded-circle bg-label-${bgColor}">${avatarText}</span>`;
                                            })()
                                        }
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href='javascript:editar(${JSON.stringify(row)});' class="text-heading text-truncate">
                                        <span class="fw-medium">${ row.pg_nome }</span>
                                    </a>
                                </div>
                            </div>
                        `;
                }
            },
            // { targets: 1, render: (data, type, row) => `<span class="text-heading">${row.nome}</span>` },
            { targets: 2, render: (data, type, row) => `<span class="text-heading">${ (row.secao ? row.secao.sigla : "" )}</span>` },
            {
                targets: -1,
                title: "Ações",
                searchable: false,
                orderable: false,
                render: (data, type, row) => `
                    <div class="d-flex align-items-center">
                        <a href="javascript:deletar(${row.id})" class="btn btn-icon"><i class="bx bx-trash icon-md deletar"></i></a>
                        <a href="javascript:editar(${row.id})" class="btn btn-icon"><i class="bx bx-edit icon-md"></i></a>
                        <a href="javascript:resetar(${row.id})" class="btn btn-icon"><i class="bx bx-key icon-md"></i></a>
                    </div>
                `
            }
        ],
        order: [[0, "asc"]],
        layout: {
            topStart: { rowClass: "row mx-3 my-0 justify-content-between", features: [{ pageLength: { menu: [10, 25, 50, 100], text: "_MENU_" } }] },
            topEnd: {
                features: [{
                    search: {
                        placeholder: "Buscar",
                        text: "_INPUT_"
                    }
                }, {
                    buttons: [
                        {
                        text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Adicionar Militar</span>',
                        className: "add-new btn btn-primary",
                        attr: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#modalMilitar"
                        }
                    }]
                }]
            },
            bottomStart: { rowClass: "row mx-3 justify-content-between", features: ["info"] },
            bottomEnd: { paging: { firstLast: false } }
        },
        language: {
            sLengthMenu: "_MENU_",
            searchPlaceholder: "Buscar usuário",
            paginate: {
                next: '<i class="bx bx-chevron-right icon-18px"></i>',
                previous: '<i class="bx bx-chevron-left icon-18px"></i>'
            }
        },
        responsive: {
            details: {
                display: DataTable.Responsive.display.modal({
                    header: (row) => `Detalhes de ${row.data().full_name}`
                }),
                type: "column",
                renderer: (api, rowIdx, columns) => {
                    const rows = columns
                        .map(col => col.title ? `<tr><td>${col.title}:</td><td>${col.data}</td></tr>` : "")
                        .join("");

                    if (!rows) return false;

                    const container = document.createElement("div");
                    container.classList.add("table-responsive");
                    container.innerHTML = `<table class="table"><tbody>${rows}</tbody></table>`;
                    return container;
                }
            }
        },
        initComplete: function () {
            this.api();
        }
    });

    document.addEventListener("show.bs.modal", (e) => {
        if (e.target.classList.contains("dtr-bs-modal")) l();
    });

    document.addEventListener("hide.bs.modal", (e) => {
        if (e.target.classList.contains("dtr-bs-modal")) l();
    });

    setTimeout(() => {
        const styleAdjustments = [
            { selector: ".dt-buttons .btn", classToRemove: "btn-secondary" },
            { selector: ".dt-search .form-control", classToRemove: "form-control-sm" },
            { selector: ".dt-length .form-select", classToRemove: "form-select-sm", classToAdd: "ms-0" },
            { selector: ".dt-length", classToAdd: "mb-md-6 mb-0" },
            { selector: ".dt-search", classToAdd: "mb-md-6 mb-2" },
            { selector: ".dt-layout-end", classToRemove: "justify-content-between", classToAdd: "d-flex gap-md-4 justify-content-md-between justify-content-center gap-4 flex-wrap mt-0" },
            { selector: ".dt-layout-start", classToAdd: "mt-0" },
            { selector: ".dt-buttons", classToAdd: "d-flex gap-4 mb-md-0 mb-6" },
            { selector: ".dt-layout-table", classToRemove: "row mt-2" },
            { selector: ".dt-layout-full", classToRemove: "col-md col-12", classToAdd: "table-responsive" }
        ];

        styleAdjustments.forEach(({ selector, classToRemove, classToAdd }) => {
            document.querySelectorAll(selector).forEach(element => {
                if (classToRemove) classToRemove.split(" ").forEach(cls => element.classList.remove(cls));
                if (classToAdd) classToAdd.split(" ").forEach(cls => element.classList.add(cls));
            });
        });
    }, 100);


    const form = document.getElementById('form-militar');

    FormValidation.formValidation(form, {
        fields: {
            nome: {
                validators: {
                    notEmpty: {
                        message: 'O nome é obrigatório'
                    },
                    stringLength: {
                        min: 3,
                        message: 'O nome deve ter pelo menos 3 caracteres'
                    }
                }
            },
            nomeguerra: {
                validators: {
                    notEmpty: {
                        message: 'O nome de guerra é obrigatório'
                    },
                    stringLength: {
                        min: 2,
                        message: 'O nome deve ter pelo menos 2 caracteres'
                    }
                }
            },
            cpf: {
                validators: {
                    notEmpty: {
                        message: 'O CPF é obrigatório'
                    },
                    regexp: {
                        regexp: /^\d{3}\.\d{3}\.\d{3}-\d{2}$/,
                        message: 'Formato inválido de CPF (XXX.XXX.XXX-XX)'
                    }
                }
            },
            telefone: {
                validators: {
                    // notEmpty: {
                    //     message: 'O telefone é obrigatório'
                    // },
                    regexp: {
                        regexp: /^\(\d{2}\) \d{5}-\d{4}$/,
                        message: 'Formato inválido de telefone ((XX) XXXXX-XXXX)'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: 'Formato de email inválido'
                    }
                }
            },
            dtnascimento: {
                validators: {
                    // notEmpty: {
                    //     message: 'A data de nascimento é obrigatória'
                    // },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'Formato de data inválido'
                    }
                }
            },
            dtpraca: {
                validators: {
                    // notEmpty: {
                    //     message: 'A data de praça é obrigatória'
                    // },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'Formato de data inválido'
                    }
                }
            },
            postograduacao_id: { validators: { notEmpty: { message: 'Selecione um posto/graduação' } } },
            om_servico_id: { validators: { notEmpty: { message: 'Selecione uma OM de serviço' } } },
            om_vinculo_id: { validators: { notEmpty: { message: 'Selecione uma OM de vínculo' } } },
            secao_id: { validators: { notEmpty: { message: 'Selecione uma seção' } } },
            level: { validators: { notEmpty: { message: 'Selecione um nível' } } }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5(),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }).on('core.form.valid',function(){
        $.post('/administrativo/militares/store', {
            id : id.value,
            nome : nome.value,
            nomeguerra : nomeguerra.value,
            cpf : cpf.value,
            postograduacao_id : postograduacao_id.value,
            telefone : telefone.value,
            email : email.value,
            veterano : veterano.checked,
            dtnascimento : dtnascimento.value,
            dtpraca : dtpraca.value,
            om_servico_id : om_servico_id.value,
            om_vinculo_id : om_vinculo_id.value,
            secao_id : secao_id.value,
            level : level.value 
        }).done(function (response) {
            Swal.fire({
                icon: "success",
                title: "Inserido",
                text: "Militar inserido com sucesso!",
                customClass: { confirmButton: "btn btn-success" }
            }).then(() => {
                location.reload();
            });
        }).fail(function(error){
            Swal.fire({
                icon: "error",
                title: "Erro ao inserir",
                text: "Ocorreu um erro ao tentar inserir o militar.",
                customClass: { confirmButton: "btn btn-danger" }
            });
        });
    });
});

$('#modalMilitar').on('shown.bs.modal', function (e) {
    $("#nome").focus();
});

function deletar(id){
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
                    text: "ID do militar não encontrado!",
                    customClass: { confirmButton: "btn btn-danger" }
                });
                return;
            }
            // Faz a requisição AJAX para deletar a instituição
            $.post('/administrativo/militares/delete', { id: id })
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
                        text: "Ocorreu um erro ao tentar excluir o militar.",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                });
        }
    });
}

function editar(id){
    $.ajax({
        url: '/administrativo/militar/show',
        method: 'POST',
        data: {
            id: id,
        },
        success: function (response) {
            console.log(response);
            $('#modalMilitar').modal('show');
            $("#id").val(response.id); 
            $("#nome").val(response.nome); 
            $("#nomeguerra").val(response.nomeguerra); 
            $("#cpf").val(response.cpf); 
            $("#postograduacao_id").val(response.postograduacao_id);
            $("#telefone").val(response.telefone); 
            $("#email").val(response.email); 
            if(response.veterano){
                $("#veterano").attr("checked","true");
            }
            $("#dtnascimento").val(response.dtnascimento); 
            $("#dtpraca").val(response.dtpraca); 
            $("#om_servico_id").val(response.om_servico_id);
            $("#om_vinculo_id").val(response.om_vinculo_id);
            $("#secao_id").val(response.secao_id);
            $("#level").val(response.level);
        },
        error: function (xhr) {
            console.error('Erro ao buscar plano.', xhr);
        }
    });
}

function resetar(id){
    Swal.fire({
        title: "Tem certeza que deseja Resetar a senha?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, Resetar",
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
                    text: "ID do militar não encontrado!",
                    customClass: { confirmButton: "btn btn-danger" }
                });
                return;
            }
            // Faz a requisição AJAX para deletar a instituição
            $.post('/administrativo/militares/resetpassword', { id: id })
                .done((resposta) => {
                    Swal.fire({
                        icon: "success",
                        title: "Resetada",
                        text: "Senha resetada com sucesso!",
                        customClass: { confirmButton: "btn btn-success" }
                    }).then(() => {
                    });
                })
                .fail(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Erro ao deletar",
                        text: "Ocorreu um erro ao resetar a senha",
                        customClass: { confirmButton: "btn btn-danger" }
                    });
                });
        }
    });
}