$(function () {

    $('#txtCNPJ').mask('99.999.999/9999-99'); 
    $('#txtCelular').mask('99-99999-9999');
    $('#txtTelFixo').mask('99-9999-9999');
    $('#txtCEP').mask('99999-999');
    $('#txtHoraInicio').mask('99:99');
    $('#txtHoraFim').mask('99:99');

    // Limpa valores do formulario de cep
    function limpa_formulario_cep() {
        $("#txtEndereco").val("");
        $("#txtBairro").val("");
        $("#txtCidade").val("");
        $("#sltEstado").val("");
    }

    //Quando o campo cep perde o foco
    $("#txtCEP").blur(function () {

        //Nova variavel "cep" somente com digitos
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado
        if (cep != "") {

            //Expressao regular para validar o CEP
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice
                $("#txtEndereco").val("...");
                $("#txtBairro").val("...");
                $("#txtCidade").val("...");
                $("#sltEstado").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta
                        $("#txtEndereco").val(dados.logradouro);
                        $("#txtBairro").val(dados.bairro);
                        $("#txtCidade").val(dados.localidade);
                        $("#sltEstado").val(dados.uf);
                    }
                    else {
                        //CEP pesquisado nao foi encontrado
                        limpa_formulario_cep();
                        alert("CEP não encontrado.");
                    }
                });
            }
            else {
                //cep eh invalido
                limpa_formulario_cep();
                alert("Formato de CEP inválido.");
            }
        }
        else {
            //cep sem valor, limpa formulario
            limpa_formulario_cep();
        }
    });

    //metodo para validar CNPJ
    $.validator.addMethod("verificaCNPJ", function (value, element) {
        var b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2], c = value;
        if ((c = c.replace(/[^\d]/g, "").split("")).length != 14)
            return false;
        for (var i = 0, n = 0; i < 12; n += c[i] * b[++i])
            ;
        if (c[12] != (((n %= 11) < 2) ? 0 : 11 - n))
            return false;
        for (var i = 0, n = 0; i <= 12; n += c[i] * b[i++])
            ;
        if (c[13] != (((n %= 11) < 2) ? 0 : 11 - n))
            return false;
        return true;
    }, "Informe um CNPJ válido.");

    //VALIDACAO FORMULARIO
    $('#frmUnidade').validate({
        rules: {
            txtNomeUnidade: {
                required: true,
                minlength: 2
            },
            txtNomeFantasia: {
                required: true,
                minlength: 2
            },
            txtRazaoSocial: {
                required: true,
                minlength: 2
            },
            txtCNPJ: {
                required: true,
                verificaCNPJ: true
            },
            txtInscEstadual: {
                required: true
            },
            txtFilialResp: {
                required: true,
                minlength: 2
            },
            txtEmail: {
                required: true,
                email: true
            },
            txtTelFixo: {
                required: true
            },
            txtCEP: {
                required: true
            },
            txtEndereco: {
                required: true
            },
            txtBairro: {
                required: true
            },
            txtCidade: {
                required: true,
                minlength: 3
            },
            'chkDiaFuncionamento[]': {
                required: true
            },
            txtHoraInicio: {
                required: true
            },
            txtHoraFim: {
                required: true
            }
        },
        messages: {
            txtNomeUnidade: {
                required: "O campo Nome Unidade é obrigatório.",
                minlength: "O campo Nome Unidade deve conter no mínimo 2 caracteres."
            },
            txtNomeFantasia: {
                required: "O campo Nome Fantasia é obrigatório.",
                minlength: "O campo Nome Fantasia deve conter no mínimo 2 caracteres."
            },
            txtRazaoSocial: {
                required: "O campo Razão Social é obrigatório.",
                minlength: "O campo Razão Social deve conter no mínimo 2 caracteres."
            },
            txtCNPJ: {
                required: "O campo CNPJ é obrigatório."
            },
            txtInscEstadual: {
                required: "O campo Inscrição Estadual é obrigatório."
            },
            txtFilialResp: {
                required: "O campo Filial Responsável é obrigatório.",
                minlength: "O campo Filial Responsável deve conter no mínimo 2 caracteres."
            },
            txtEmail: {
                required: "O campo Email é obrigatório.",
                email: "Informe um email válido."
            },
            txtTelFixo: {
                required: "O campo Telefone Fixo é obrigatório."
            },
            txtCEP: {
                required: "O campo CEP é obrigatório."
            },
            txtEndereco: {
                required: "O campo Endereço é obrigatório."
            },
            txtBairro: {
                required: "O campo Bairro é obrigatório."
            },
            txtCidade: {
                required: "O campo Cidade é obrigatório.",
                minlength: "O campo Cidade deve conter no mínimo 3 caracteres."
            },
            'chkDiaFuncionamento[]': {
                required: "O campo Dias Funcionamento é obrigatório."
            },
            txtHoraInicio: {
                required: "O campo Horário Início é obrigatório."
            },
            txtHoraFim: {
                required: "O campo Horário Fim é obrigatório."
            }
        }
    });
});