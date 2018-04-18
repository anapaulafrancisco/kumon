$(function () {

    $("#txtDataLancamento").datepicker().mask("99/99/9999");

    $('.buscaAlunoCombo').selectpicker();

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
    $('#frmProgresso').validate({
        rules: {
            sltCurso: {
                required: true
            },
            sltAluno: {
                required: true
            },
            sltEstagio: {
                required: true
            },
            txtQtdeFolha: {
                required: true
            },
            txtDataLancamento: {
                required: true,
                dateBR: true
            }
        },
        messages: {
            sltCurso: {
                required: "O campo Curso é obrigatório."
            },
            sltAluno: {
                required: "O campo Aluno é obrigatório."
            },
            sltEstagio: {
                required: "O campo Estágio é obrigatório."
            },
            txtQtdeFolha: {
                required: "O campo Qtde folhas é obrigatório."
            },
            txtDataLancamento: {
                required: "O campo Data é obrigatório."
            }
        }
    });
});