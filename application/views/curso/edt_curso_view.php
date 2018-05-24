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
					Curso
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('curso/gerenciar');?>"><i class="fa fa-folder-open"></i> Curso</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Editar Curso</h3>
                            </div>

                            <?php echo Notificacao::getNotificacao(); ?>  

                            <form name="frmCurso" id="frmCurso" action="<?php echo base_url('curso/editar/id/salvar'); ?>" method='post' class="form-horizontal">
                                <?php 
                                    $idCurso = urlencode(base64_encode($arrCurso['id_curso']));
                                ?>
                                <input type="hidden" name="hddIdCurso" value="<?php echo $idCurso; ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txtNomeCurso" class="control-label col-md-3 col-sm-3 col-xs-12">Nome Curso *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="txtNomeCurso" id="txtNomeCurso" class="form-control <?php echo (form_error('txtNomeCurso') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNomeCurso', $arrCurso['nome_curso']); ?>">
                                            <input type="hidden" name="hddNomeCurso" value="<?php echo $arrCurso['nome_curso']; ?>" >
                                            <?php echo form_error('txtNomeCurso'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtDataCurso" class='control-label col-md-3 col-sm-3 col-xs-12'>Data *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtDataCurso" id="txtDataCurso" class="form-control <?php echo (form_error('txtDataCurso') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtDataCurso', $arrCurso['data_curso_formatada']); ?>" >
                                            <?php echo form_error('txtDataCurso'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php 
                                                $statusAtivo = (int)$arrCurso['ativo'] == 1 ? "checked='checked'" : '';
                                                $statusInativo = (int)$arrCurso['ativo'] == 0 ? "checked='checked'" : '';
                                            ?>
                                            <label><input type='radio' class='flat' name='rdoStatusCurso' value='1' <?php echo $statusAtivo; ?> <?php echo set_radio('rdoStatusCurso', '1'); ?>> Ativo</label><br />
                                            <label><input type='radio' class='flat' name='rdoStatusCurso' value='0' <?php echo $statusInativo; ?> <?php echo set_radio('rdoStatusCurso', '0'); ?>> Inativo</label>
                                        </div>	
                                    </div>
                                                    
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url("curso/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
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
    <!-- jquery ui -->
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
    <!--datapicker pt-BR (calendario traducao)-->
    <script src="<?php echo base_url('assets/js/datepicker-pt-BR.js'); ?>"></script>
    <!--regras curso-->
    <script src="<?php echo base_url('assets/js/curso.js'); ?>"></script>

</body>
</html>
