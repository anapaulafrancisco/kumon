$(function () {

    $('.buscaUsuarioCombo').selectpicker();

    $('#txtUsuario').keyup(function () {
        $(this).val($(this).val().toLowerCase());
    });

    //VALIDACAO FORMULARIO
    $('#frmUsuario').validate({
        rules: {
            sltTipoUsuario: {
                required: true
            },
            sltNomeUsuario: {
                required: true
            },
            txtEmail: {
                required: true
            },
            txtUsuario: {
                required: true,
                minlength: 3
            },
            pwdSenha: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            sltTipoUsuario: {
                required: "O campo Tipo usuário é obrigatório."
            },
            sltNomeUsuario: {
                required: "O campo Nome é obrigatório."
            },
            txtEmail: {
                required: "O campo Email é obrigatório."
            },
            txtUsuario: {
                required: "O campo Usuário é obrigatório.",
                minlength: "O campo Usuário deve conter no mínimo 3 caracteres."
            },
            pwdSenha: {
                required: "O campo Senha é obrigatório.",
                minlength: "O campo Senha deve conter no mínimo 5 caracteres."
            }
        }
    });
});