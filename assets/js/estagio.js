$(function () {
   
    //VALIDACAO FORMULARIO
    $('#frmEstagio').validate({
       rules: {
            txtNomeEstagio: {
                required: true
            },
            txtQtdeBloco: {
                required: true
            },	  
            txtQtdeFolha: {
                required: true
            },	  
            txtNumeracaoBloco: {
                required: true
            },
            rdoStatusEstagio: {
                required: true
            }	  
        },
        messages: {
            txtNomeEstagio: {
                required: "O campo Nome estágio é obrigatório."
            },
            txtQtdeBloco: {
                required: "O campo Qtde bloco é obrigatório."
            },
            txtQtdeFolha: {
                required: "O campo Qtde folha é obrigatório."
            },
            txtNumeracaoBloco: {
                required: "O campo Númeração bloco é obrigatório."
            },
            rdoStatusEstagio: {
                required: "O campo Status é obrigatório."
            }
        }
    });
});