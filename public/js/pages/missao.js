$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $("[name='_token']").val()
    }
});

$('#uploadmissoes').on("submit", function (e) {
    e.preventDefault();
    let dados = $('#uploadmissoes').serialize();
    alert("Enviando Arquivos... aguarde!");
    // console.log(dados);
    let formData = new FormData(this);
    $.ajax({
        url: "/administrativo/importacoes/missoes", // Rota definida no Laravel
        type: "POST",
        data: formData,
        processData: false,  // Impede que o jQuery processe os dados
        contentType: false,  // Não define o tipo de conteúdo (necessário para FormData)
        headers: {
            "X-CSRF-TOKEN": $("[name='_token']").val() // Proteção CSRF
        },
        success: function (response) {
            $("#message").html(`<p style="color: green;">${response.message}</p>`);
        },
        error: function (xhr) {
            let msg = "Erro desconhecido";
            if (xhr.responseJSON && xhr.responseJSON.error) {
                msg = xhr.responseJSON.error;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            } else if (xhr.responseText) {
                msg = xhr.responseText;
            }
            $("#message").html(`<p style="color: red;">Erro: ${msg}</p>`);
        }
    });
})