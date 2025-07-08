<div class="mb-2">
    <div class="card-datatable">
        <table class="datatables-users table border-top" id="{{$id}}">
            <thead>
                <tr>
                    @foreach($options as $key => $value)
                        <th>{{$key}}</th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@php
    $columns = "";
    foreach($options as $key => $value){
        $columns .= "{ data: '{$value}' },";
    }
    $columns .= '{ data: "Ações" }';
@endphp

<script>
    document.addEventListener("DOMContentLoaded", function (e) {
        let table = document.getElementById("{{$id}}");
    dataTable = new DataTable(table, {
        ajax: "{{$link}}",
        columns: [
            {!! $columns !!}
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
                        text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">{{$titulobotao}}</span>',
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
    });
    
</script>