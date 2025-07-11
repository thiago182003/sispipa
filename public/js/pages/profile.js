document.addEventListener("DOMContentLoaded", function(e) {
    {
        let e = document.querySelector("#formAccountSettings")
          , t = document.querySelector("#formAccountDeactivation")
          , n = t.querySelector(".deactivate-account")
          , o = (e && FormValidation.formValidation(e, {
            fields: {
                firstName: {
                    validators: {
                        notEmpty: {
                            message: "Please enter first name"
                        }
                    }
                },
                lastName: {
                    validators: {
                        notEmpty: {
                            message: "Please enter last name"
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
                e.on("plugins.message.placed", function(e) {
                    e.element.parentElement.classList.contains("input-group") && e.element.parentElement.insertAdjacentElement("afterend", e.messageElement)
                })
            }
        }),
        t && FormValidation.formValidation(t, {
            fields: {
                accountActivation: {
                    validators: {
                        notEmpty: {
                            message: "Please confirm you want to delete account"
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger,
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: ""
                }),
                submitButton: new FormValidation.plugins.SubmitButton,
                fieldStatus: new FormValidation.plugins.FieldStatus({
                    onStatusChanged: function(e) {
                        e ? n.removeAttribute("disabled") : n.setAttribute("disabled", "disabled")
                    }
                }),
                autoFocus: new FormValidation.plugins.AutoFocus
            },
            init: e => {
                e.on("plugins.message.placed", function(e) {
                    e.element.parentElement.classList.contains("input-group") && e.element.parentElement.insertAdjacentElement("afterend", e.messageElement)
                })
            }
        }),
        document.querySelector("#accountActivation"))
          , a = (n && (n.onclick = function() {
            1 == o.checked && Swal.fire({
                text: "Are you sure you would like to deactivate your account?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton: "btn btn-primary me-2",
                    cancelButton: "btn btn-label-secondary"
                },
                buttonsStyling: !1
            }).then(function(e) {
                e.value ? Swal.fire({
                    icon: "success",
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    customClass: {
                        confirmButton: "btn btn-success"
                    }
                }) : e.dismiss === Swal.DismissReason.cancel && Swal.fire({
                    title: "Cancelled",
                    text: "Deactivation Cancelled!!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success"
                    }
                })
            })
        }
        ),
        document.querySelector("#phoneNumber"))
          , i = document.querySelector("#zipCode")
          , l = (a && (a.addEventListener("input", e => {
            e = e.target.value.replace(/\D/g, "");
            a.value = formatGeneral(e, {
                blocks: [3, 3, 4],
                delimiters: [" ", " "]
            })
        }
        ),
        registerCursorTracker({
            input: a,
            delimiter: " "
        })),
        i && i.addEventListener("input", e => {
            i.value = formatNumeral(e.target.value, {
                delimiter: "",
                numeral: !0
            })
        }
        ),
        document.getElementById("uploadedAvatar"))
          , s = document.querySelector(".account-file-input")
          , r = document.querySelector(".account-image-reset");
        if (l) {
            let e = l.src;
            s.onchange = () => {
                s.files[0] && (l.src = window.URL.createObjectURL(s.files[0]))
            }
            ,
            r.onclick = () => {
                s.value = "",
                l.src = e
            }
        }
    }
}),
$(function() {
    var e = $(".select2");
    e.length && e.each(function() {
        var e = $(this);
        e.wrap('<div class="position-relative"></div>'),
        e.select2({
            dropdownParent: e.parent()
        })
    })
});
