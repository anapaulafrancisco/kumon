<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();

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
					Pessoa
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('pessoa/gerenciar');?>"><i class="fa fa-graduation-cap"></i> Pessoa</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Editar Pessoa</h3>
                            </div>

                            <?php echo Notificacao::getNotificacao(); ?>  

                            <form name="frmPessoa" id="frmPessoa" action="<?php echo base_url('pessoa/editar/id/salvar'); ?>" method='post' class="form-horizontal">
                                <?php 
                                    $idPessoa = urlencode(base64_encode($arrPessoa['id_pessoa']));
                                ?>
                                <input type="hidden" name="hddIdPessoa" value="<?php echo $idPessoa; ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txtNome" class="control-label col-md-3 col-sm-3 col-xs-12">Nome *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtNome" id="txtNome" class="form-control <?php echo (form_error('txtNome') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNome', $arrPessoa['nome_pessoa']); ?>">
                                            <?php echo form_error('txtNome'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtEmail" class="control-label col-md-3 col-sm-3 col-xs-12">Email *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="email" id="txtEmail" name="txtEmail" class="form-control <?php echo (form_error('txtEmail') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtEmail', $arrPessoa['email']); ?>" >
                                            <?php echo form_error('txtEmail'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtTelResidencial" class='control-label col-md-3 col-sm-3 col-xs-12'>Telefone Residencial *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtTelResidencial" id="txtTelResidencial" class="form-control" value="<?php echo set_value('txtTelResidencial', $arrPessoa['telefone']); ?>" >
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtCelular" class='control-label col-md-3 col-sm-3 col-xs-12'>Celular</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCelular" id="txtCelular" class="form-control <?php echo (form_error('txtCelular') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCelular', $arrPessoa['celular']); ?>">
                                            <?php echo form_error('txtCelular'); ?>
                                        </div>
                                    </div>
                                  
                                    <div class='form-group'>
                                        <label for="txtEstado" class='control-label col-md-3 col-sm-3 col-xs-12'>Tipo</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltTipo" id="sltTipo" class="form-control">
                                                <?php 
                                                    $arrTipo = array('orientador', 'auxiliar');

                                                    if($arrCredencial['perfis'] != 1 || $arrCredencial['perfis'] != '1,2')
                                                    {
                                                        $arrTipo = array('auxiliar');
                                                    }
                                                    
                                                    foreach ($arrTipo as $tipo) 
                                                    {
                                                        $tipoSelecionado = $arrPessoa['tipo'] == $tipo ? "selected='selected'" : ''; 
                                                        echo "<option value='{$tipo}' {$tipoSelecionado} >{$tipo}</option>";
                                                    } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php 
                                                $statusAtivo = (int)$arrPessoa['ativo'] == 1 ? "checked='checked'" : '';
                                                $statusInativo = (int)$arrPessoa['ativo'] == 0 ? "checked='checked'" : '';
                                            ?>
                                            <label><input type='radio' class='flat' name='rdoStatusPessoa' value='1' <?php echo $statusAtivo; ?> <?php echo set_radio('rdoStatusPessoa', '1'); ?>> Ativo</label><br />
                                            <label><input type='radio' class='flat' name='rdoStatusPessoa' value='0' <?php echo $statusInativo; ?> <?php echo set_radio('rdoStatusPessoa', '0'); ?>> Inativo</label>
                                        </div>	
                                    </div>
                                                    
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url("pessoa/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
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
    <!--regras aluno-->
    <script src="<?php echo base_url('assets/js/pessoa.js'); ?>"></script>

</body>
</html>
