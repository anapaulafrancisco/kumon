$(function () {

    $('#txtCelular').mask('99-99999-9999');
    $('#txtTelResidencial').mask('99-9999-9999');

    //VALIDACAO FORMULARIO
    $('#frmPessoa').validate({
        rules: {
            txtNome: {
                required: true,
                minlength: 2
            },
            txtEmail: {
                required: true,
                email: true
            },
            txtTelResidencial: {
                required: true
            }
        },
        messages: {
            txtNome: {
                required: "O campo Nome é obrigatório",
                minlength: "O campo Nome deve conter no mínimo 2 caracteres."
            },
            txtEmail: {
                required: "O campo Email é obrigatório.",
                email: "Informe um email válido."
            },
            txtTelResidencial: {
                required: "O campo Telefone Residencial é obrigatório."
            }
        }
    });
});