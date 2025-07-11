let fv, offCanvasEl;
document.addEventListener("DOMContentLoaded", function (e) {
    t = document.getElementById("form-add-new-record"),
        setTimeout(() => {
            let e = document.querySelector(".create-new")
                , t = document.querySelector("#add-new-record");
            e && e.addEventListener("click", function () {
                offCanvasEl = new bootstrap.Offcanvas(t),
                    t.querySelector(".dt-full-name").value = "",
                    t.querySelector(".dt-post").value = "",
                    t.querySelector(".dt-email").value = "",
                    t.querySelector(".dt-date").value = "",
                    t.querySelector(".dt-salary").value = "",
                    offCanvasEl.show()
            })
        }
            , 200),
        fv = FormValidation.formValidation(t, {
            fields: {
                basicFullname: {
                    validators: {
                        notEmpty: {
                            message: "The name is required"
                        }
                    }
                },
                basicPost: {
                    validators: {
                        notEmpty: {
                            message: "Post field is required"
                        }
                    }
                },
                basicEmail: {
                    validators: {
                        notEmpty: {
                            message: "The Email is required"
                        },
                        emailAddress: {
                            message: "The value is not a valid email address"
                        }
                    }
                },
                basicDate: {
                    validators: {
                        notEmpty: {
                            message: "Joining Date is required"
                        },
                        date: {
                            format: "MM/DD/YYYY",
                            message: "The value is not a valid date"
                        }
                    }
                },
                basicSalary: {
                    validators: {
                        notEmpty: {
                            message: "Basic Salary is required"
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger,
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".form-control-validation"
                }),
                submitButton: new FormValidation.plugins.SubmitButton,
                autoFocus: new FormValidation.plugins.AutoFocus
            },
            init: e => {
                e.on("plugins.message.placed", function (e) {
                    e.element.parentElement.classList.contains("input-group") && e.element.parentElement.insertAdjacentElement("afterend", e.messageElement)
                })
            }
        }),
        (t = document.querySelector('[name="basicDate"]')) && t.flatpickr({
            enableTime: !1,
            monthSelectorType: "static",
            static: !0,
            dateFormat: "m/d/Y",
            onChange: function () {
                fv.revalidateField("basicDate")
            }
        });
    var r, t = document.querySelector(".datatables-basic");
    let o;
    t && ((s = document.createElement("h5")).classList.add("card-title", "mb-0", "text-md-start", "text-center"),
        s.innerHTML = "DataTable with Buttons",
        o = new DataTable(t, {
            ajax: assetsPath + "json/table-datatable.json",
            columns: [{
                data: "id"
            }, {
                data: "id",
                orderable: !1,
                render: DataTable.render.select()
            }, {
                data: "id"
            }, {
                data: "full_name"
            }, {
                data: "email"
            }, {
                data: "start_date"
            }, {
                data: "salary"
            }, {
                data: "status"
            }, {
                data: "id"
            }],
            columnDefs: [{
                className: "control",
                orderable: !1,
                searchable: !1,
                responsivePriority: 2,
                targets: 0,
                render: function (e, t, a, s) {
                    return ""
                }
            }, {
                targets: 1,
                orderable: !1,
                searchable: !1,
                responsivePriority: 3,
                checkboxes: !0,
                checkboxes: {
                    selectAllRender: '<input type="checkbox" class="form-check-input">'
                },
                render: function () {
                    return '<input type="checkbox" class="dt-checkboxes form-check-input">'
                }
            }, {
                targets: 2,
                searchable: !1,
                visible: !1
            }, {
                targets: 3,
                responsivePriority: 4,
                render: function (e, t, a, s) {
                    var n = a.avatar
                        , r = a.full_name
                        , a = a.post;
                    let o;
                    if (n)
                        o = `<img src="${assetsPath}img/avatars/${n}" alt="Avatar" class="rounded-circle">`;
                    else {
                        n = ["success", "danger", "warning", "info", "dark", "primary", "secondary"][Math.floor(6 * Math.random())];
                        let e = r.match(/\b\w/g) || [];
                        e = ((e.shift() || "") + (e.pop() || "")).toUpperCase(),
                            o = `<span class="avatar-initial rounded-circle bg-label-${n}">${e}</span>`
                    }
                    return `
              <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                  <div class="avatar me-2">
                    ${o}
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <span class="emp_name text-truncate text-heading">${r}</span>
                  <small class="emp_post text-truncate">${a}</small>
                </div>
              </div>
            `
                }
            }, {
                responsivePriority: 1,
                targets: 4
            }, {
                targets: -2,
                render: function (e, t, a, s) {
                    var a = a.status
                        , n = {
                            1: {
                                title: "Current",
                                class: "bg-label-primary"
                            },
                            2: {
                                title: "Professional",
                                class: "bg-label-success"
                            },
                            3: {
                                title: "Rejected",
                                class: "bg-label-danger"
                            },
                            4: {
                                title: "Resigned",
                                class: "bg-label-warning"
                            },
                            5: {
                                title: "Applied",
                                class: "bg-label-info"
                            }
                        };
                    return void 0 === n[a] ? e : `
              <span class="badge ${n[a].class}">
                ${n[a].title}
              </span>
            `
                }
            }, {
                targets: -1,
                title: "Actions",
                orderable: !1,
                searchable: !1,
                className: "d-flex align-items-center",
                render: function (e, t, a, s) {
                    return '<div class="d-inline-block"><a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></a><ul class="dropdown-menu dropdown-menu-end m-0"><li><a href="javascript:;" class="dropdown-item">Details</a></li><li><a href="javascript:;" class="dropdown-item">Archive</a></li><div class="dropdown-divider"></div><li><a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a></li></ul></div><a href="javascript:;" class="btn btn-icon item-edit"><i class="icon-base bx bx-edit icon-sm"></i></a>'
                }
            }],
            select: {
                style: "multi",
                selector: "td:nth-child(2)"
            },
            order: [[2, "desc"]],
            layout: {
                top2Start: {
                    rowClass: "row card-header flex-column flex-md-row pb-0",
                    features: [s]
                },
                top2End: {
                    features: [{
                        buttons: [{
                            extend: "collection",
                            className: "btn btn-label-primary dropdown-toggle me-4",
                            text: '<span class="d-flex align-items-center gap-2"><i class="icon-base bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span></span>',
                            buttons: [{
                                extend: "print",
                                text: '<span class="d-flex align-items-center"><i class="icon-base bx bx-printer me-1"></i>Print</span>',
                                className: "dropdown-item",
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7],
                                    format: {
                                        body: function (e, t, a) {
                                            if (e.length <= 0 || !(-1 < e.indexOf("<")))
                                                return e;
                                            {
                                                e = (new DOMParser).parseFromString(e, "text/html");
                                                let t = "";
                                                var s = e.querySelectorAll(".user-name");
                                                return 0 < s.length ? s.forEach(e => {
                                                    e = e.querySelector(".fw-medium")?.textContent || e.querySelector(".d-block")?.textContent || e.textContent;
                                                    t += e.trim() + " "
                                                }
                                                ) : t = e.body.textContent || e.body.innerText,
                                                    t.trim()
                                            }
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
                                text: '<span class="d-flex align-items-center"><i class="icon-base bx bx-file me-1"></i>Csv</span>',
                                className: "dropdown-item",
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7],
                                    format: {
                                        body: function (e, t, a) {
                                            if (e.length <= 0)
                                                return e;
                                            e = (new DOMParser).parseFromString(e, "text/html");
                                            let s = "";
                                            var n = e.querySelectorAll(".user-name");
                                            return 0 < n.length ? n.forEach(e => {
                                                e = e.querySelector(".fw-medium")?.textContent || e.querySelector(".d-block")?.textContent || e.textContent;
                                                s += e.trim() + " "
                                            }
                                            ) : s = e.body.textContent || e.body.innerText,
                                                s.trim()
                                        }
                                    }
                                }
                            }, {
                                extend: "excel",
                                text: '<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-export me-1"></i>Excel</span>',
                                className: "dropdown-item",
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7],
                                    format: {
                                        body: function (e, t, a) {
                                            if (e.length <= 0)
                                                return e;
                                            e = (new DOMParser).parseFromString(e, "text/html");
                                            let s = "";
                                            var n = e.querySelectorAll(".user-name");
                                            return 0 < n.length ? n.forEach(e => {
                                                e = e.querySelector(".fw-medium")?.textContent || e.querySelector(".d-block")?.textContent || e.textContent;
                                                s += e.trim() + " "
                                            }
                                            ) : s = e.body.textContent || e.body.innerText,
                                                s.trim()
                                        }
                                    }
                                }
                            }, {
                                extend: "pdf",
                                text: '<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-pdf me-1"></i>Pdf</span>',
                                className: "dropdown-item",
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7],
                                    format: {
                                        body: function (e, t, a) {
                                            if (e.length <= 0)
                                                return e;
                                            e = (new DOMParser).parseFromString(e, "text/html");
                                            let s = "";
                                            var n = e.querySelectorAll(".user-name");
                                            return 0 < n.length ? n.forEach(e => {
                                                e = e.querySelector(".fw-medium")?.textContent || e.querySelector(".d-block")?.textContent || e.textContent;
                                                s += e.trim() + " "
                                            }
                                            ) : s = e.body.textContent || e.body.innerText,
                                                s.trim()
                                        }
                                    }
                                }
                            }, {
                                extend: "copy",
                                text: '<i class="icon-base bx bx-copy me-1"></i>Copy',
                                className: "dropdown-item",
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7],
                                    format: {
                                        body: function (e, t, a) {
                                            if (e.length <= 0)
                                                return e;
                                            e = (new DOMParser).parseFromString(e, "text/html");
                                            let s = "";
                                            var n = e.querySelectorAll(".user-name");
                                            return 0 < n.length ? n.forEach(e => {
                                                e = e.querySelector(".fw-medium")?.textContent || e.querySelector(".d-block")?.textContent || e.textContent;
                                                s += e.trim() + " "
                                            }
                                            ) : s = e.body.textContent || e.body.innerText,
                                                s.trim()
                                        }
                                    }
                                }
                            }]
                        }, {
                            text: '<span class="d-flex align-items-center gap-2"><i class="icon-base bx bx-plus icon-sm"></i> <span class="d-none d-sm-inline-block">Add New Record</span></span>',
                            className: "create-new btn btn-primary"
                        }]
                    }]
                },
                topStart: {
                    rowClass: "row m-3 my-0 justify-content-between",
                    features: [{
                        pageLength: {
                            menu: [10, 25, 50, 100],
                            text: "Show_MENU_entries"
                        }
                    }]
                },
                topEnd: {
                    search: {
                        placeholder: ""
                    }
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
                paginate: {
                    next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>',
                    previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>'
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
                        var s, n, r, a = a.map(function (e) {
                            return "" !== e.title ? `<tr data-dt-row="${e.rowIndex}" data-dt-column="${e.columnIndex}">
                      <td>${e.title}:</td>
                      <td>${e.data}</td>
                    </tr>` : ""
                        }).join("");
                        return !!a && ((s = document.createElement("div")).classList.add("table-responsive"),
                            n = document.createElement("table"),
                            s.appendChild(n),
                            n.classList.add("table"),
                            n.classList.add("datatables-basic"),
                            (r = document.createElement("tbody")).innerHTML = a,
                            n.appendChild(r),
                            s)
                    }
                }
            }
        }),
        r = 101,
        fv.on("core.form.valid", function () {
            var e = document.querySelector(".add-new-record .dt-full-name").value
                , t = document.querySelector(".add-new-record .dt-post").value
                , a = document.querySelector(".add-new-record .dt-email").value
                , s = document.querySelector(".add-new-record .dt-date").value
                , n = document.querySelector(".add-new-record .dt-salary").value;
            "" != e && (o.row.add({
                id: r,
                full_name: e,
                post: t,
                email: a,
                start_date: s,
                salary: "$" + n,
                status: 5
            }).draw(),
                r++,
                offCanvasEl.hide())
        }),
        document.addEventListener("click", function (e) {
            e.target.classList.contains("delete-record") && (o.row(e.target.closest("tr")).remove().draw(),
                e = document.querySelector(".dtr-bs-modal")) && e.classList.contains("show") && bootstrap.Modal.getInstance(e)?.hide()
        }));
    t = document.querySelector(".dt-complex-header");
    let a;
    t && (a = new DataTable(t, {
        ajax: assetsPath + "json/table-datatable.json",
        columns: [{
            data: "full_name"
        }, {
            data: "email"
        }, {
            data: "city"
        }, {
            data: "post"
        }, {
            data: "salary"
        }, {
            data: "status"
        }, {
            data: ""
        }],
        columnDefs: [{
            targets: -2,
            render: function (e, t, a, s) {
                var a = a.status
                    , n = {
                        1: {
                            title: "Current",
                            class: "bg-label-primary"
                        },
                        2: {
                            title: "Professional",
                            class: "bg-label-success"
                        },
                        3: {
                            title: "Rejected",
                            class: "bg-label-danger"
                        },
                        4: {
                            title: "Resigned",
                            class: "bg-label-warning"
                        },
                        5: {
                            title: "Applied",
                            class: "bg-label-info"
                        }
                    };
                return void 0 === n[a] ? e : `
              <span class="badge ${n[a].class}">
                ${n[a].title}
              </span>
            `
            }
        }, {
            targets: -1,
            title: "Actions",
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
                return '<div class="d-inline-block"><a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></a><ul class="dropdown-menu dropdown-menu-end m-0"><li><a href="javascript:;" class="dropdown-item">Details</a></li><li><a href="javascript:;" class="dropdown-item">Archive</a></li><div class="dropdown-divider"></div><li><a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a></li></ul></div><a href="javascript:;" class="btn btn-icon item-edit"><i class="icon-base bx bx-edit icon-sm"></i></a>'
            }
        }],
        order: [[2, "desc"]],
        layout: {
            topStart: {
                rowClass: "row mx-3 my-0 justify-content-between",
                features: [{
                    pageLength: {
                        menu: [7, 10, 25, 50, 100],
                        text: "Show_MENU_entries"
                    }
                }]
            },
            topEnd: {
                search: {
                    placeholder: ""
                }
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
        displayLength: 7,
        language: {
            paginate: {
                next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>',
                previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>'
            }
        }
    }),
        document.addEventListener("click", function (e) {
            e.target.classList.contains("delete-record") && (a.row(e.target.closest("tr")).remove().draw(),
                e = document.querySelector(".dtr-bs-modal")) && e.classList.contains("show") && bootstrap.Modal.getInstance(e)?.hide()
        }));
    var s = document.querySelector(".dt-row-grouping");
    let n;
    s && (n = new DataTable(s, {
        ajax: assetsPath + "json/table-datatable.json",
        columns: [{
            data: "id"
        }, {
            data: "full_name"
        }, {
            data: "post"
        }, {
            data: "email"
        }, {
            data: "city"
        }, {
            data: "start_date"
        }, {
            data: "salary"
        }, {
            data: "status"
        }, {
            data: ""
        }],
        columnDefs: [{
            className: "control",
            orderable: !1,
            targets: 0,
            searchable: !1,
            render: function (e, t, a, s) {
                return ""
            }
        }, {
            visible: !1,
            targets: 2
        }, {
            targets: -2,
            render: function (e, t, a, s) {
                var a = a.status
                    , n = {
                        1: {
                            title: "Current",
                            class: "bg-label-primary"
                        },
                        2: {
                            title: "Professional",
                            class: "bg-label-success"
                        },
                        3: {
                            title: "Rejected",
                            class: "bg-label-danger"
                        },
                        4: {
                            title: "Resigned",
                            class: "bg-label-warning"
                        },
                        5: {
                            title: "Applied",
                            class: "bg-label-info"
                        }
                    };
                return void 0 === n[a] ? e : `
              <span class="badge ${n[a].class}">
                ${n[a].title}
              </span>
            `
            }
        }, {
            targets: -1,
            title: "Actions",
            orderable: !1,
            searchable: !1,
            className: "d-flex align-items-center",
            render: function (e, t, a, s) {
                return '<div class="d-inline-block"><a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow me-1" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded icon-base"></i></a><div class="dropdown-menu dropdown-menu-end m-0"><a href="javascript:;" class="dropdown-item">Details</a><a href="javascript:;" class="dropdown-item">Archive</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a></div></div><a href="javascript:;" class="btn btn-icon item-edit"><i class="icon-base bx bx-edit icon-sm"></i></a>'
            }
        }],
        layout: {
            topStart: {
                rowClass: "row mx-3 my-0 justify-content-between",
                features: [{
                    pageLength: {
                        menu: [7, 10, 25, 50, 100],
                        text: "Show_MENU_entries"
                    }
                }]
            },
            topEnd: {
                search: {
                    placeholder: ""
                }
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
        order: [[2, "asc"]],
        displayLength: 7,
        language: {
            paginate: {
                next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>',
                previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>'
            }
        },
        drawCallback: function (e) {
            var t = this.api();
            let n = t.rows({
                page: "current"
            }).nodes()
                , r = null;
            t.column(2, {
                page: "current"
            }).data().each(function (e, t) {
                var a, s;
                r !== e && ((a = document.createElement("tr")).classList.add("group"),
                    (s = document.createElement("td")).setAttribute("colspan", "8"),
                    s.textContent = e,
                    a.appendChild(s),
                    n[t].parentNode.insertBefore(a, n[t]),
                    r = e)
            })
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
                    var s, n, r, a = a.map(function (e) {
                        return "" !== e.title ? `<tr data-dt-row="${e.rowIndex}" data-dt-column="${e.columnIndex}">
                      <td>${e.title}:</td>
                      <td>${e.data}</td>
                    </tr>` : ""
                    }).join("");
                    return !!a && ((s = document.createElement("div")).classList.add("table-responsive"),
                        n = document.createElement("table"),
                        s.appendChild(n),
                        n.classList.add("table"),
                        (r = document.createElement("tbody")).innerHTML = a,
                        n.appendChild(r),
                        s)
                }
            }
        }
    }),
        document.addEventListener("click", function (e) {
            e.target.classList.contains("delete-record") && (n.row(e.target.closest("tr")).remove().draw(),
                e = document.querySelector(".dtr-bs-modal")) && e.classList.contains("show") && bootstrap.Modal.getInstance(e)?.hide()
        }));
    var t = document.querySelector(".dt-multilingual");
    let l;
    t && (l = new DataTable(t, {
        ajax: assetsPath + "json/table-datatable.json",
        columns: [{
            data: "id"
        }, {
            data: "full_name"
        }, {
            data: "post"
        }, {
            data: "email"
        }, {
            data: "start_date"
        }, {
            data: "salary"
        }, {
            data: "status"
        }, {
            data: ""
        }],
        columnDefs: [{
            className: "control",
            orderable: !1,
            targets: 0,
            searchable: !1,
            render: function (e, t, a, s) {
                return ""
            }
        }, {
            targets: -2,
            render: function (e, t, a, s) {
                var a = a.status
                    , n = {
                        1: {
                            title: "Current",
                            class: "bg-label-primary"
                        },
                        2: {
                            title: "Professional",
                            class: "bg-label-success"
                        },
                        3: {
                            title: "Rejected",
                            class: "bg-label-danger"
                        },
                        4: {
                            title: "Resigned",
                            class: "bg-label-warning"
                        },
                        5: {
                            title: "Applied",
                            class: "bg-label-info"
                        }
                    };
                return void 0 === n[a] ? e : `
              <span class="badge ${n[a].class}">
                ${n[a].title}
              </span>
            `
            }
        }, {
            targets: -1,
            title: "Actions",
            orderable: !1,
            className: "",
            searchable: !1,
            render: function (e, t, a, s) {
                return '<div class="d-flex align-items-center"><div class="d-inline-block"><a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow me-1" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-sm"></i></a><div class="dropdown-menu dropdown-menu-end m-0"><a href="javascript:;" class="dropdown-item">Details</a><a href="javascript:;" class="dropdown-item">Archive</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a></div></div><a href="javascript:;" class="btn btn-icon item-edit"><i class="icon-base bx bx-edit icon-sm"></i></a></div>'
            }
        }],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json",
            paginate: {
                next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>',
                previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>'
            }
        },
        order: [[2, "desc"]],
        displayLength: 7,
        layout: {
            topStart: {
                rowClass: "row m-3 justify-content-between",
                features: [{
                    pageLength: {
                        menu: [7, 10, 25, 50, 100]
                    }
                }]
            },
            topEnd: {
                search: {
                    placeholder: "Geben Sie hier die Suche ein"
                }
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
        responsive: {
            details: {
                display: DataTable.Responsive.display.modal({
                    header: function (e) {
                        return "Details of " + e.data().full_name
                    }
                }),
                type: "column",
                renderer: function (e, t, a) {
                    var s, n, r, a = a.map(function (e) {
                        return "" !== e.title ? `<tr data-dt-row="${e.rowIndex}" data-dt-column="${e.columnIndex}">
                      <td>${e.title}:</td>
                      <td>${e.data}</td>
                    </tr>` : ""
                    }).join("");
                    return !!a && ((s = document.createElement("div")).classList.add("table-responsive"),
                        n = document.createElement("table"),
                        s.appendChild(n),
                        n.classList.add("table"),
                        (r = document.createElement("tbody")).innerHTML = a,
                        n.appendChild(r),
                        s)
                }
            }
        }
    }),
        document.addEventListener("click", function (e) {
            e.target.classList.contains("delete-record") && (l.row(e.target.closest("tr")).remove().draw(),
                e = document.querySelector(".dtr-bs-modal")) && e.classList.contains("show") && bootstrap.Modal.getInstance(e)?.hide()
        })),
        setTimeout(() => {
            [{
                selector: ".dt-buttons .btn",
                classToRemove: "btn-secondary"
            }, {
                selector: ".dt-search .form-control",
                classToRemove: "form-control-sm",
                classToAdd: "ms-4"
            }, {
                selector: ".dt-length .form-select",
                classToRemove: "form-select-sm"
            }, {
                selector: ".dt-layout-table",
                classToRemove: "row mt-2"
            }, {
                selector: ".dt-layout-end",
                classToAdd: "mt-0"
            }, {
                selector: ".dt-layout-end .dt-search",
                classToAdd: "mt-0 mt-md-6"
            }, {
                selector: ".dt-layout-start",
                classToAdd: "mt-0"
            }, {
                selector: ".dt-layout-end .dt-buttons",
                classToAdd: "mb-0"
            }].forEach(({ selector: e, classToRemove: a, classToAdd: s }) => {
                document.querySelectorAll(e).forEach(t => {
                    a && a.split(" ").forEach(e => t.classList.remove(e)),
                        s && s.split(" ").forEach(e => t.classList.add(e))
                }
                )
            }
            )
        }
            , 100)
});
