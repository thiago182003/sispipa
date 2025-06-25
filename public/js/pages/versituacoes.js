
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name='_token']").val()
        }
    });
    // Para cada select de situação, armazena o valor inicial em um data attribute
    console.log($('.form-select'));
    $('.form-select').each(function () {
        $(this).data('original', $(this).val());
    });

    $('#saveButton').click(function () {
        // Itera sobre cada select
        $('.form-select').each(function () {
            let $select = $(this);
            let currentVal = $select.val();
            let originalVal = $select.data('original');

            // Se o valor foi alterado
            if (currentVal !== originalVal) {
                // Obtém o id do militar da linha (assumindo que a linha tem data-id)
                let militarId = $select.closest('tr').data('id');

                // Envia a atualização via AJAX
                $.ajax({
                    url: '/administrativo/salvarsituacoes',
                    method: 'POST',
                    data: {
                        id: militarId,
                        situacao: currentVal
                    },
                    success: function (response) {
                        // Atualiza o valor original para o valor atual
                        $select.data('original', currentVal);
                        // Adiciona uma classe para indicar que foi salvo (ex.: .saved)
                        $select.closest('tr').addClass('saved');
                        // Opcional: mostrar uma mensagem ou ícone de sucesso na linha
                    },
                    error: function (xhr) {
                        console.error('Erro ao atualizar militar ' + militarId, xhr);
                        // Opcional: exibir mensagem de erro na linha ou via alert
                    }
                });
            }
        });
    });
});