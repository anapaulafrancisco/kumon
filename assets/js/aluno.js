$(function () {

    //calcula a idade
    $("#txtDtNasc").on("change", function () {

        var arrData = $(this).val().split("/");
        var dataNascimento = arrData[2] + "-" + arrData[1] + "-" + arrData[0];
        var dataNascimentoFormatada = new Date(dataNascimento);
        var dataAtual = new Date();
        var anoAtual = dataAtual.getFullYear();
        var aniversarioEsteAno = new Date(anoAtual, dataNascimentoFormatada.getMonth(), dataNascimentoFormatada.getDate());
        var idade = anoAtual - dataNascimentoFormatada.getFullYear();

        if (aniversarioEsteAno > dataAtual) {
            idade--;
        }

        $("#txtIdade").val(idade);

        if (idade < 18) {
            $("#div-responsavel").css('display', 'block');
        } else {
            $("#div-responsavel").css('display', 'none');
        }
    });

    //mascaras
    $('#txtCEP').mask('99999-999');
    $('#txtCPF').mask('999.999.999-99');
    $('#txtCPFResponsavel').mask('999.999.999-99');
    $('#txtCelular').mask('99-99999-9999');
    $('#txtTelResidencial').mask('99-9999-9999');

    $("#txtDtNasc")
        .datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-50:+0"
        })
        .mask("99/99/9999");

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

    //metodo para validar CPF
    $.validator.addMethod("verificaCPF", function (value, element) {
        if (value == '123.456.789-09')
            return false;
        var c = value;
        if ((c = c.replace(/[^\d]/g, "").split("")).length != 11)
            return false;
        if (new RegExp("^" + c[0] + "{11}$").test(c.join("")))
            return false;
        for (var s = 10, n = 0, i = 0; s >= 2; n += c[i++] * s--)
            ;
        if (c[9] != (((n %= 11) < 2) ? 0 : 11 - n))
            return false;
        for (var s = 11, n = 0, i = 0; s >= 2; n += c[i++] * s--)
            ;
        if (c[10] != (((n %= 11) < 2) ? 0 : 11 - n))
            return false;
        return true;
    }, "Informe um CPF válido."); // mensagem padrao

    //metodo para validar data
    $.validator.addMethod("dateBR", function (value, element) {
        //if (value.length != 10)data.length != 10 isNaN(dia) || isNaN(mes) || isNaN(ano) || 
        //     return false;
        var data = value;
        var dataQuebrada = data.split("/");
        var dia = dataQuebrada[0];
        var mes = dataQuebrada[1];
        var ano = dataQuebrada[2];
        if (dia > 31 || mes > 12)
            return false;
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31)
            return false;
        if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0)))
            return false;
        if (ano < 1900)
            return false;
        return true;

    }, "Informe uma data válida.");

    //VALIDACAO FORMULARIO
    $('#frmAluno').validate({
        rules: {
            txtNome: {
                required: true,
                minlength: 2
            },
            txtEmail: {
                required: true,
                email: true
            },
            txtCPF: {
                verificaCPF: true
            },
            txtDtNasc: {
                required: true,
                dateBR: true
            },
            txtTelResidencial: {
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
            txtNomeResponsavel: {
                required: true,
                minlength: 2
            },
            txtCPFResponsavel: {
                verificaCPF: true
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
            txtDtNasc: {
                required: "O campo Data Nascimento é obrigatório."
            },
            txtTelResidencial: {
                required: "O campo Telefone Residencial é obrigatório."
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
            txtNomeResponsavel: {
                required: "O campo Nome responsável é obrigatório.",
                minlength: "O campo Nome responsável deve conter no mínimo 2 caracteres."
            }
        }
    });
});