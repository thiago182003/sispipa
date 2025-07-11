document.addEventListener("DOMContentLoaded", function() {
    {
        let e = document.querySelector("#formAuthentication");
        e && "undefined" != typeof FormValidation && FormValidation.formValidation(e, {
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: "Please enter username"
                        },
                        stringLength: {
                            min: 6,
                            message: "Username must be more than 6 characters"
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: "Please enter your email"
                        },
                        emailAddress: {
                            message: "Please enter a valid email address"
                        }
                    }
                },
                "email-username": {
                    validators: {
                        notEmpty: {
                            message: "Digite seu CPF"
                        },
                        stringLength: {
                            // min: 6,
                            // message: "Username must be more than 6 characters"
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: "Digite sua senha"
                        },
                        stringLength: {
                            min: 6,
                            message: "A senha deve ter no minimo 6 caracteres"
                        }
                    }
                },
                "confirm-password": {
                    validators: {
                        notEmpty: {
                            message: "Please confirm password"
                        },
                        identical: {
                            compare: () => e.querySelector('[name="password"]').value,
                            message: "The password and its confirmation do not match"
                        },
                        stringLength: {
                            min: 6,
                            message: "Password must be more than 6 characters"
                        }
                    }
                },
                terms: {
                    validators: {
                        notEmpty: {
                            message: "Please agree to terms & conditions"
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
                defaultSubmit: new FormValidation.plugins.DefaultSubmit,
                autoFocus: new FormValidation.plugins.AutoFocus
            },
            init: e => {
                e.on("plugins.message.placed", e => {
                    e.element.parentElement.classList.contains("input-group") && e.element.parentElement.insertAdjacentElement("afterend", e.messageElement)
                }
                )
            }
        });
        var a = document.querySelectorAll(".numeral-mask");
        0 < a.length && a.forEach(a => {
            a.addEventListener("input", e => {
                a.value = e.target.value.replace(/\D/g, "")
            }
            )
        }
        )
    }
});
