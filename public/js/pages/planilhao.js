
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $("[name='_token']").val()
  }
});

$('#upload').on("submit",function(e){
  e.preventDefault();
  let dados = $('#upload').serialize();
  alert("Enviando dados... aguarde!");
  // console.log(dados);
  let formData = new FormData(this);
  $.ajax({
    url: "/importacoes/planilhao", // Rota definida no Laravel
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
        $("#message").html(`<p style="color: red;">Erro: ${xhr.error}</p>`);
    }
});
})