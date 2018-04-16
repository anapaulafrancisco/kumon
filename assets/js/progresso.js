$(function () {

    $('.buscaAlunoCombo').selectpicker();

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
            }
        }
    });
});