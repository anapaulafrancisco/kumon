<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();

    $pathVoltar = base_url("curso/ver/estagio/" . $idCursoCrip);
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
					Estágio
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo $pathVoltar; ?>"><i class="fa fa-folder-open"></i> Estágio</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Incluir Estágio</h3>
                            </div>

                            <?php echo Notificacao::getNotificacao(); ?>  

                            <form name="frmEstagio" id="frmEstagio" action="<?php echo base_url('curso/estagio/salvar'); ?>" method='post' class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txtNomeEstagio" class="control-label col-md-3 col-sm-3 col-xs-12">Nome estágio *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="txtNomeEstagio" name="txtNomeEstagio" class="form-control <?php echo (form_error('txtNomeEstagio') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNomeEstagio'); ?>" >
                                            <?php echo form_error('txtNomeEstagio'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtQtdeBloco" class="control-label col-md-3 col-sm-3 col-xs-12">Qtde bloco *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="txtQtdeBloco" name="txtQtdeBloco" class="form-control <?php echo (form_error('txtQtdeBloco') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtQtdeBloco'); ?>" >
                                            <?php echo form_error('txtQtdeBloco'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtQtdeFolha" class="control-label col-md-3 col-sm-3 col-xs-12">Qtde folha *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="txtQtdeFolha" name="txtQtdeFolha" class="form-control <?php echo (form_error('txtQtdeFolha') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtQtdeFolha'); ?>" >
                                            <?php echo form_error('txtQtdeFolha'); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="txtNumeracaoBloco" class="control-label col-md-3 col-sm-3 col-xs-12">Numeração bloco *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="txtNumeracaoBloco" name="txtNumeracaoBloco" class="form-control <?php echo (form_error('txtNumeracaoBloco') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNumeracaoBloco'); ?>" >
                                            <?php echo form_error('txtNumeracaoBloco'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <label><input type='radio' class='flat' name='rdoStatusEstagio' value='1' <?php echo set_radio('rdoStatusEstagio', '1', true); ?>> Ativo</label><br />
                                            <label><input type='radio' class='flat' name='rdoStatusEstagio' value='0' <?php echo set_radio('rdoStatusEstagio', '0'); ?>> Inativo</label>
                                        </div>	
                                    </div>

                                    <input type="hidden" name="hddCursoID" value="<?php echo $idCursoCrip; ?>" />
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo $pathVoltar; ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
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
    <!--regras estagio-->
    <script src="<?php echo base_url('assets/js/estagio.js'); ?>"></script>

</body>
</html>
