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
            { data: "anoreferencia" }, // NOVA COLUNA
            { data: "boletim" },       // NOVA COLUNA
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
        selMilitar: {
            validators: {
                notEmpty: { message: "Selecione um militar" }
            }
        },
        qtdparcelas: {
            validators: {
                notEmpty: { message: "Selecione a quantidade de parcelas" }
            }
        },
        anoreferencia: {
            validators: {
                notEmpty: { message: "Informe o ano de referência" },
                regexp: {
                    regexp: /^\d{4}$/,
                    message: "Ano deve ter 4 dígitos"
                }
            }
        }
        // Os campos de períodos são dinâmicos, então a validação pode ser feita no submit
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
    let form = document.getElementById('form-secao');
    let formData = new FormData(form);

    // Adiciona os períodos manualmente (caso não estejam no form)
    let qtd = parseInt(document.getElementById('qtdparcelas').value);
    for (let i = 1; i <= 3; i++) {
        formData.set(`p${i}inicio`, document.getElementById(`p${i}inicio`) ? document.getElementById(`p${i}inicio`).value : '');
        formData.set(`p${i}fim`, document.getElementById(`p${i}fim`) ? document.getElementById(`p${i}fim`).value : '');
    }

    $.ajax({
        url: '/administrativo/planodeferias/store',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Inserido",
                text: "Plano salvo com sucesso!",
                customClass: { confirmButton: "btn btn-success" }
            }).then(() => {
                $('#offcanvasAddUser').offcanvas('hide');
                dataTable.ajax.reload();
            });
        },
        error: function(error){
            Swal.fire({
                icon: "error",
                title: "Erro ao salvar",
                text: "Ocorreu um erro ao tentar salvar o plano.",
                customClass: { confirmButton: "btn btn-danger" }
            });
        }
    });
});
    
    myOffcanvas.addEventListener('show.bs.offcanvas', function () {
        $("#id").val("");
        $("#anoreferencia").val("");
        $("#qtdparcelas").val("");
        $("#selMilitar").val("");
        $("#selMilitar").change();
        document.getElementById('periodos-container').innerHTML = '';
        document.getElementById('mudancas-container').innerHTML = '';
        mudancaIndex = 0;
    });

    
});

function editar(id){
    $.ajax({
        url: '/e1/planodeferias/show',
        method: 'POST',
        data: { id: id },
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
            $("#boletim").val(response.boletim);

            // Exibir as alterações já salvas
            let mudancas = response.mudancas || [];
            let container = document.getElementById('mudancas-container');
            container.innerHTML = '';
            mudancas.forEach(function(mudanca, idx){
                let div = document.createElement('div');
                div.className = 'row align-items-end mb-3 mudanca-item';
                div.innerHTML = `
                    <div class="col-7">
                        <label class="form-label">DIEx de Alteração</label>
                        <input type="text" class="form-control" value="${mudanca.diex}" readonly />
                    </div>
                    <div class="col-4">
                        <label class="form-label">Documento PDF</label>
                        <a href="/storage/${mudanca.pdf_path}" target="_blank" class="btn btn-outline-primary w-100">Baixar PDF</a>
                    </div>
                `;
                container.appendChild(div);
            });
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
        dropdownParent: $("#offcanvasAddUser")
    });

    // NOVO: Atualiza a quantidade de dias ao selecionar um militar
    $('#selMilitar').on('change', function() {
        let militarId = $(this).val();
        let $dias = $('#dias-disponiveis');
        $dias.text('');
        if (militarId) {
            $.post('/administrativo/militares/get-veterano', { id: militarId })
                .done(function(res) {
                    let total = res.veterano ? 60 : 30;
                    // Agora busca os descontos
                    $.post('/e1/descontoemferias/get-descontos', { militar_id: militarId })
                        .done(function(desc) {
                            let descontado = desc.total_descontado || 0;
                            let disponivel = total - descontado;
                            let texto = disponivel + ' dias a gozar';
                            if (descontado > 0) {
                                texto += ` (${descontado} descontados)`;
                            }
                            $dias.text(texto);
                        })
                        .fail(function() {
                            $dias.text(total + ' dias a gozar');
                        });
                })
                .fail(function() {
                    $dias.text('Não foi possível obter a informação.');
                });
        }
    });
});

// Adicione isso ao final do planodeferias.js ou dentro de um @push('scripts') no Blade

function criarCamposPeriodos(qtd) {
    const container = document.getElementById('periodos-container');
    container.innerHTML = '';
    let dias = qtd == 1 ? 30 : qtd == 2 ? 15 : 10;
    for (let i = 1; i <= qtd; i++) {
        container.innerHTML += `
            <div class="mb-6 form-control-validation">
                <label class="form-label" for="p${i}inicio">Início - ${i}º Período</label>
                <input type="date" id="p${i}inicio" name="p${i}inicio" class="form-control" placeholder="Início - ${i}º Período" aria-label="Início - ${i}º Período"/>
            </div>
            <div class="mb-6 form-control-validation">
                <label class="form-label" for="p${i}fim">Fim - ${i}º Período</label>
                <input type="date" id="p${i}fim" name="p${i}fim" class="form-control" placeholder="Fim - ${i}º Período" aria-label="Fim - ${i}º Período" readonly/>
            </div>
        `;
    }
    // Adiciona listeners para calcular datas
    for (let i = 1; i <= qtd; i++) {
        document.getElementById(`p${i}inicio`).addEventListener('change', function() {
            let inicio = this.value;
            if (inicio) {
                let data = new Date(inicio);
                data.setDate(data.getDate() + dias - 1);
                let fim = data.toISOString().split('T')[0];
                document.getElementById(`p${i}fim`).value = fim;
            } else {
                document.getElementById(`p${i}fim`).value = '';
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('qtdparcelas').addEventListener('change', function() {
        let qtd = parseInt(this.value);
        if (qtd >= 1 && qtd <= 3) {
            criarCamposPeriodos(qtd);
        } else {
            document.getElementById('periodos-container').innerHTML = '';
        }
    });

    // Validação para ano referência: só números e 4 dígitos
    document.getElementById('anoreferencia').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 4);
    });
});

let mudancaIndex = 0;
document.getElementById('btn-add-mudanca').addEventListener('click', function() {
    mudancaIndex++;
    const container = document.getElementById('mudancas-container');
    const div = document.createElement('div');
    div.className = 'row align-items-end mb-3 mudanca-item';
    div.innerHTML = `
        <div class="col-7">
            <label class="form-label" for="diex_${mudancaIndex}">DIEx de Alteração</label>
            <input type="text" class="form-control" name="diex_alteracao[]" id="diex_${mudancaIndex}" placeholder="Informe o DIEx"/>
        </div>
        <div class="col-4">
            <label class="form-label" for="pdf_${mudancaIndex}">Documento PDF</label>
            <input type="file" class="form-control" name="pdf_alteracao[]" id="pdf_${mudancaIndex}" accept="application/pdf"/>
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-link text-danger btn-remove-mudanca" title="Remover">
                <i class="bx bx-x"></i>
            </button>
        </div>
    `;
    container.appendChild(div);

    // Botão de remover
    div.querySelector('.btn-remove-mudanca').addEventListener('click', function() {
        div.remove();
    });
});

// Limpar campos ao abrir o modal
myOffcanvas.addEventListener('show.bs.offcanvas', function () {
    // ...existing code...
    document.getElementById('mudancas-container').innerHTML = '';
    mudancaIndex = 0;
});