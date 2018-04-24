<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();

    $arrDiaSemana = array('SEG', 'TER', 'QUA', 'QUI', 'SEX');
 
?>
    <!-- jquery-ui CSS-->
    <link href="<?php echo base_url('assets/css/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet">
    <!-- bootstrap select -->
    <link href="<?php echo base_url('assets/css/bootstrap-select.min.css'); ?>" rel="stylesheet">

    <style type="text/css">
        input.error, textarea.error {
            background: #FAEDEC;
            border: 1px solid #E85445;
        }

        label.error{
            color: #E74C3C;
        }

        .erro-dia{
            color: #E74C3C;
            font-weight: bold;
        }
        .buscaAlunoCombo .btn-default{
            background-color: #FFFFFF !important; 
            color: #555 !important;
        }
        
        .btn dropdown-toggle btn-default bs-placeholder{
            color: 555;
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
					Matrícula
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('matricula/gerenciar');?>"><i class="fa fa-book"></i> Matrícula</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Matricular Aluno</h3>
                            </div>

                            <?php echo Notificacao::getNotificacao(); ?>  

                            <form name="frmMatricula" id="frmMatricula" action="<?php echo base_url('matricula/incluir/salvar'); ?>" method='post' class="form-horizontal">
                                
                                <div class="box-body">

                                    <div class='form-group'>
                                        <label for="sltCurso" class='control-label col-md-3 col-sm-3 col-xs-12'>Curso *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltCurso" id="sltCurso" class="form-control">
                                            <option value="">Selecione</option>
                                                <?php 
                                                    foreach ($arrCurso as $curso) 
                                                    {
                                                        $repopular = set_select('sltCurso', $curso);
                                                        echo "<option value='{$curso['id_curso']}' {$repopular} >{$curso['nome_curso']}</option>";
                                                    } 
                                                ?>
                                            </select>
                                             <?php echo form_error('sltCurso'); ?>
                                        </div>
                                    </div>
                                    
                                    <div class='form-group'>
                                        <label for="sltEstagio" class='control-label col-md-3 col-sm-3 col-xs-12'>Estágio *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltEstagio" id="sltEstagio" class="form-control">
                                                <option value="">Selecione o curso</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="sltAluno" class='control-label col-md-3 col-sm-3 col-xs-12'>Aluno</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltAluno" id="sltAluno" class="form-control buscaAlunoCombo" data-live-search="true">
                                                <?php 
                                                    foreach ($arrAluno as $aluno) 
                                                    {
                                                        $repopular = set_select('sltAluno', $aluno['id_aluno']);
                                                        echo "<option value='{$aluno['id_aluno']}' {$repopular} >{$aluno['nome_aluno']}</option>";
                                                    } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>               

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Dia/Hora Aula *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php  
                                                $arrDiasSelecionados = explode(',', $arrInfoUnidade['dias_semana']);

                                                foreach($arrDiasSelecionados as $dia)
                                                {
                                                    echo " <label><input type='checkbox' name='chkDiaAula$dia' id='chkDiaAula$dia' value='{$dia}' class='flat chk-dia-aula'> {$dia} </label>";
                                                    echo " <input type='text' name='txtHoraAula$dia' id='txtHoraAula$dia' style='display: none; width: 60px;' />";
                                                }
                                            ?>
                                           <span class="erro-dia"></span>
                                        </div>
                                    </div>

                                   <div class='form-group'>
                                        <label for="txtDataMatricula" class='control-label col-md-3 col-sm-3 col-xs-12'>Data Matrícula *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtDataMatricula" id="txtDataMatricula" class="form-control <?php echo (form_error('txtDataMatricula') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtDataMatricula'); ?>" >
                                            <?php echo form_error('txtDataMatricula'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <label><input type='radio' class='flat' name='rdoStatusMatricula' value='1' <?php echo set_radio('rdoStatusMatricula', '1', TRUE); ?>> Ativo</label><br />
                                        </div>	
                                    </div>
                                                    
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url("matricula/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
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
    <!-- jquery validate additional methods (para validar os checkbox de dia da semana) -->
    <script src="<?php echo base_url('assets/js/jquery.validate.additional-methods.min.js'); ?>"></script>
    <!-- maskedinput (mascaras)-->
	<script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
    <!-- jquery ui -->
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
    <!--datapicker pt-BR (calendario traducao)-->
    <script src="<?php echo base_url('assets/js/datepicker-pt-BR.js'); ?>"></script>            
    <!-- bootstrap select -->
    <script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>"></script>
    <!-- bootstrap select traducao-->
    <script src="<?php echo base_url('assets/js/i18n/defaults-pt_BR.min.js'); ?>"></script>
    <!--regras matricula-->
    <script src="<?php echo base_url('assets/js/matricula.js'); ?>"></script>     

    <script>
        
        //exibe combo de estagio de acordo com o curso
        $("#sltCurso").change(function () {
            var idCurso = $(this).val();

            $.post(
                "<?php echo base_url() ?>ajax/estagioAjax/buscaEstagio",
                { idCurso: idCurso },
                function (estagios) {
                    $("#sltEstagio").html(estagios);
                }
            );
        });   
    
    </script>

</body>
</html>
