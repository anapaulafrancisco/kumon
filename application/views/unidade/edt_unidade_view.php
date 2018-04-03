<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();

    $arrEstado = array('AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SE', 'SP', 'TO');

    $arrDiaSemana = array('SEG', 'TER', 'QUA', 'QUI', 'SEX');

?>

    <!-- jquery-ui CSS-->
    <link href="<?php echo base_url('assets/css/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet">

    <style type="text/css">
        input.error, textarea.error {
            background: #FAEDEC;
            border: 1px solid #E85445;
        }

        label.error{
            color: #E74C3C;
        }

    </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

	<header class="main-header">
		<!-- logo -->
		<?php getTopo(); ?>
		<!-- menu -->
    	<?php getMenu(); ?>
  
  		<!-- Content Wrapper. Contains page content -->
  		<div class="content-wrapper">
   			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Unidade
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('unidade/editar');?>"><i class="fa fa-home"></i> Unidade</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Editar Unidade</h3>
                            </div>
                            
                            <?php echo Notificacao::getNotificacao(); ?>

                            <form name="frmUnidade" id="frmUnidade" action="<?php echo base_url('unidade/editar/id/salvar'); ?>" method='post' class="form-horizontal">
                                <?php 
                                    $idUnidade = urlencode(base64_encode($arrUnidade['id_unidade']));
                                ?>
                                <input type="hidden" name="hddIdUnidade" value="<?php echo $idUnidade; ?>">
                                <div class="box-body">
                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Orientador</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrUnidade['nome_pessoa']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtNomeUnidade" class="control-label col-md-3 col-sm-3 col-xs-12">Nome Unidade *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtNomeUnidade" id="txtNomeUnidade" class="form-control <?php echo (form_error('txtNomeUnidade') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNomeUnidade', $arrUnidade['nome_unidade']); ?>">
                                            <?php echo form_error('txtNomeUnidade'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtNomeFantasia" class="control-label col-md-3 col-sm-3 col-xs-12">Nome Fantasia *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtNomeFantasia" id="txtNomeFantasia" class="form-control <?php echo (form_error('txtNomeFantasia') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNomeFantasia', $arrUnidade['nome_fantasia']); ?>">
                                            <?php echo form_error('txtNomeFantasia'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtRazaoSocial" class="control-label col-md-3 col-sm-3 col-xs-12">Razão Social *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtRazaoSocial" id="txtRazaoSocial" class="form-control <?php echo (form_error('txtRazaoSocial') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtRazaoSocial', $arrUnidade['razao_social']); ?>">
                                            <?php echo form_error('txtRazaoSocial'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtCNPJ" class="control-label col-md-3 col-sm-3 col-xs-12">CNPJ *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtCNPJ" id="txtCNPJ" class="form-control <?php echo (form_error('txtCNPJ') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCNPJ', $arrUnidade['cnpj']); ?>">
                                            <?php echo form_error('txtCNPJ'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtInscEstadual" class="control-label col-md-3 col-sm-3 col-xs-12">Inscrição Estadual *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtInscEstadual" id="txtInscEstadual" class="form-control <?php echo (form_error('txtInscEstadual') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtInscEstadual', $arrUnidade['inscricao_estadual']); ?>">
                                            <?php echo form_error('txtInscEstadual'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtFilialResp" class="control-label col-md-3 col-sm-3 col-xs-12">Filial Responsável *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtFilialResp" id="txtFilialResp" class="form-control <?php echo (form_error('txtFilialResp') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtFilialResp', $arrUnidade['filial_responsavel']); ?>">
                                            <?php echo form_error('txtFilialResp'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtEmail" class="control-label col-md-3 col-sm-3 col-xs-12">Email *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="email" id="txtEmail" name="txtEmail" class="form-control <?php echo (form_error('txtEmail') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtEmail', $arrUnidade['email']); ?>" >
                                            <?php echo form_error('txtEmail'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtTelFixo" class='control-label col-md-3 col-sm-3 col-xs-12'>Telefone Fixo *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtTelFixo" id="txtTelFixo" class="form-control" value="<?php echo set_value('txtTelFixo', $arrUnidade['telefone_fixo']); ?>" >
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtCelular" class='control-label col-md-3 col-sm-3 col-xs-12'>Celular</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCelular" id="txtCelular" class="form-control <?php echo (form_error('txtCelular') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCelular', $arrUnidade['telefone_celular']); ?>">
                                            <?php echo form_error('txtCelular'); ?>
                                        </div>
                                    </div>
                                  
                                    <div class='form-group'>
                                        <label for="txtCEP" class='control-label col-md-3 col-sm-3 col-xs-12'>CEP *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCEP" id="txtCEP" class="form-control <?php echo (form_error('txtCEP') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCEP', $arrUnidade['cep']); ?>" >
                                            <?php echo form_error('txtCEP'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtEndereco" class='control-label col-md-3 col-sm-3 col-xs-12'>Endereço *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtEndereco" id="txtEndereco" class="form-control <?php echo (form_error('txtEndereco') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtEndereco', $arrUnidade['endereco']); ?>" >
                                            <?php echo form_error('txtEndereco'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtBairro" class='control-label col-md-3 col-sm-3 col-xs-12'>Bairro *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtBairro" id="txtBairro" class="form-control <?php echo (form_error('txtBairro') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtBairro', $arrUnidade['bairro']); ?>" >
                                            <?php echo form_error('txtBairro'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtCidade" class='control-label col-md-3 col-sm-3 col-xs-12'>Cidade *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCidade" id="txtCidade" class="form-control <?php echo (form_error('txtCidade') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCidade', $arrUnidade['cidade']); ?>" >
                                            <?php echo form_error('txtCidade'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtEstado" class='control-label col-md-3 col-sm-3 col-xs-12'>Estado</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltEstado" id="sltEstado" class="form-control">
                                                <?php 
                                                    foreach ($arrEstado as $estado) 
                                                    {
                                                        $estadoSelecionado = $arrUnidade['estado'] == $estado ? "selected='selected'" : ''; 
                                                        echo "<option value='{$estado}' {$estadoSelecionado} >{$estado}</option>";
                                                    } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Dias Funcionamento *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php  
                                                $arrDiasSelecionados = explode(',', $arrUnidade['dias_semana']);

                                                foreach($arrDiaSemana as $dia)
                                                {
                                                    $diaSelecionado = '' ;
                                                    if(in_array($dia, $arrDiasSelecionados))
                                                    {
                                                        $diaSelecionado = "checked='checked'";
                                                    }
                                                
                                                    echo " <label><input type='checkbox' name='chkDiaFuncionamento[]' id='chkDiaFuncionamento[]' value='{$dia}' class='flat' {$diaSelecionado}> {$dia}</label>";
                                                }

                                                echo "<br /><label class='error' for='chkDiaFuncionamento[]'></label>";
                                                echo form_error('chkDiaFuncionamento[]');	
                                            ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtHoraInicio" class='control-label col-md-3 col-sm-3 col-xs-12'>Horário Início *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtHoraInicio" id="txtHoraInicio" class="form-control <?php echo (form_error('txtHoraInicio') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtHoraInicio', $arrUnidade['horario_inicio_formatado']); ?>" >
                                            <?php echo form_error('txtHoraInicio'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtHoraFim" class='control-label col-md-3 col-sm-3 col-xs-12'>Horário Fim *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtHoraFim" id="txtHoraFim" class="form-control <?php echo (form_error('txtHoraFim') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtHoraFim', $arrUnidade['horario_fim_formatado']); ?>" >
                                            <?php echo form_error('txtHoraFim'); ?>
                                        </div>
                                    </div>
                                </div>

                                
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>                             
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div><!-- /.box -->
                    </div><!-- /div cols -->
                </div><!-- /div row -->
            </section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

    <?php getRodape(); ?>

    <!--jquery.validate (validacao formulario)-->
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
    <!-- maskedinput (mascaras)-->
	<script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
    <!--regras unidade-->
    <script src="<?php echo base_url('assets/js/unidade.js'); ?>"></script>

</body>
</html>
