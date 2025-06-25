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
        ajax: '/operacional/municipios/show',
        columns: [
            { data: "nome" },
            { data: "estado.nome" },
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
                        extend: "collection",
                        className: "btn btn-label-secondary dropdown-toggle",
                        text: '<span class="d-flex align-items-center gap-2"><i class="icon-base bx bx-export icon-sm"></i> <span class="d-none d-sm-inline-block">Exportar</span></span>',
                        buttons: [{
                            extend: "print",
                            text: '<span class="d-flex align-items-center"><i class="icon-base bx bx-printer me-2"></i>Imprimir</span>',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [0, 1],
                                format: {
                                    body: function (e, t, a) {
                                        if (e.length <= 0)
                                            return e;
                                        e = (new DOMParser).parseFromString(e, "text/html").body.childNodes;
                                        let s = "";
                                        return e.forEach(e => {
                                            e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : s += e.textContent || e.innerText || ""
                                        }
                                        ),
                                            s
                                    }
                                }
                            },
                            customize: function (e) {
                                e.document.body.style.color = config.colors.headingColor,
                                    e.document.body.style.borderColor = config.colors.borderColor,
                                    e.document.body.style.backgroundColor = config.colors.bodyBg;
                                e = e.document.body.querySelector("table");
                                e.classList.add("compact"),
                                    e.style.color = "inherit",
                                    e.style.borderColor = "inherit",
                                    e.style.backgroundColor = "inherit"
                            }
                        }, {
                            extend: "csv",
                            text: '<span class="d-flex align-items-center"><i class="icon-base bx bx-file me-2"></i>Csv</span>',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [0, 1],
                                format: {
                                    body: function (e, t, a) {
                                        if (e.length <= 0)
                                            return e;
                                        e = (new DOMParser).parseFromString(e, "text/html").body.childNodes;
                                        let s = "";
                                        return e.forEach(e => {
                                            e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : s += e.textContent || e.innerText || ""
                                        }
                                        ),
                                            s
                                    }
                                }
                            }
                        }, {
                            extend: "excel",
                            text: '<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-export me-2"></i>Excel</span>',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [0, 1],
                                format: {
                                    body: function (e, t, a) {
                                        if (e.length <= 0)
                                            return e;
                                        e = (new DOMParser).parseFromString(e, "text/html").body.childNodes;
                                        let s = "";
                                        return e.forEach(e => {
                                            e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : s += e.textContent || e.innerText || ""
                                        }
                                        ),
                                            s
                                    }
                                }
                            }
                        }, {
                            extend: "pdf",
                            text: '<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-pdf me-2"></i>Pdf</span>',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [0, 1],
                                format: {
                                    body: function (e, t, a) {
                                        if (e.length <= 0)
                                            return e;
                                        e = (new DOMParser).parseFromString(e, "text/html").body.childNodes;
                                        let s = "";
                                        return e.forEach(e => {
                                            e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : s += e.textContent || e.innerText || ""
                                        }
                                        ),
                                            s
                                    }
                                }
                            }
                        }, {
                            extend: "copy",
                            text: '<i class="icon-base bx bx-copy me-1"></i>Copiar',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [0, 1],
                                format: {
                                    body: function (e, t, a) {
                                        if (e.length <= 0)
                                            return e;
                                        e = (new DOMParser).parseFromString(e, "text/html").body.childNodes;
                                        let s = "";
                                        return e.forEach(e => {
                                            e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : s += e.textContent || e.innerText || ""
                                        }
                                        ),
                                            s
                                    }
                                }
                            }
                        }]
                    }, {
                        text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Adicionar Municipio</span>',
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
                        return "Details of " + e.data().full_name
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
    FormValidation.formValidation(document.getElementById('form-instituicao'), {
        fields: {
            nome: {
                validators: {
                    notEmpty: {
                        message: "Preencha um nome"
                    }
                }
            },
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
        $.post('/administrativo/situacoes/store', {
            id: id.value,
            nome: nome.value,
            descricao: sigla.value,
        }).done(function (response) {
            Swal.fire({
                icon: "success",
                title: "Salvo",
                text: "Situação salva com sucesso!",
                customClass: { confirmButton: "btn btn-success" }
            }).then(() => {
                location.reload();
            });
        }).fail(function(error){
            Swal.fire({
                icon: "error",
                title: "Erro ao inserir",
                text: "Ocorreu um erro ao tentar inserir a Situação.",
                customClass: { confirmButton: "btn btn-danger" }
            });
        });

    });
    
    myOffcanvas.addEventListener('show.bs.offcanvas', function () {
        $("#id").val("");
        $("#nome").val("");
        $("#sigla").val("");
        $("#nome").trigger('focus');
    });
});