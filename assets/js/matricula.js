$(function () {

    $('.buscaAlunoCombo').selectpicker();

    $('#txtHoraAulaSEG').mask('99:99');
    $('#txtHoraAulaTER').mask('99:99');
    $('#txtHoraAulaQUA').mask('99:99');
    $('#txtHoraAulaQUI').mask('99:99');
    $('#txtHoraAulaSEX').mask('99:99');

    $(".chk-dia-aula:input:checkbox").click(function () {
        var dia = $(this).val();
        $("#txtHoraAula" + dia).toggle();
    });

    $("#txtDataMatricula").datepicker().mask("99/99/9999");
    $("#txtDataInativa").datepicker().mask("99/99/9999");

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

    $.validator.addClassRules('chk-dia-aula', {
        require_from_group: [1, ".chk-dia-aula"]
    });

    //VALIDACAO FORMULARIO
    $('#frmMatricula').validate({
        rules: {
            sltCurso: {
                required: true
            },
            sltEstagio: {
                required: true
            },
            txtIdentAluno: {
                required: true
            },
            txtDataMatricula: {
                required: true,
                dateBR: true
            },
            txtDataInativa: {
                required: true,
                dateBR: true
            },
            txtHoraAulaSEG: {
                required: "#chkDiaAulaSEG:checked",
                required: true
            },
            txtHoraAulaTER: {
                required: "#chkDiaAulaTER:checked",
                required: true
            },
            txtHoraAulaQUA: {
                required: "#chkDiaAulaQUA:checked",
                required: true
            },
            txtHoraAulaQUI: {
                required: "#chkDiaAulaQUI:checked",
                required: true
            },
            txtHoraAulaSEX: {
                required: "#chkDiaAulaSEX:checked",
                required: true
            }
        },
        messages: {
            sltCurso: {
                required: "O campo Curso é obrigatório."
            },
            sltEstagio: {
                required: "O campo Estágio é obrigatório."
            },
            txtIdentAluno: {
                required: "O campo Identificador aluno é obrigatório."
            },
            txtDataMatricula: {
                required: "O campo Data Matrícula é obrigatório."
            },
            txtDataInativa: {
                required: "O campo Data Inativa é obrigatório."
            },
            txtHoraAulaSEG: {
                required: "Hora obrigatória."
            },
            txtHoraAulaTER: {
                required: "Hora obrigatória."
            },
            txtHoraAulaQUA: {
                required: "Hora obrigatória."
            },
            txtHoraAulaQUI: {
                required: "Hora obrigatória."
            },
            txtHoraAulaSEX: {
                required: "Hora obrigatória."
            }
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('chk-dia-aula')) {
                error[0]['innerHTML'] = 'Por favor selecione ao menos um dia.'; 
                console.log(error);
                element.closest('.form-group').find('.erro-dia').html(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
});