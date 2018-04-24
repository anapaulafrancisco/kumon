<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();
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
                                <h3 class="box-title">Editar Matrícula Aluno</h3>
                            </div>

                            <?php echo Notificacao::getNotificacao(); ?>  

                            <form name="frmMatricula" id="frmMatricula" action="<?php echo base_url('matricula/editar/id/salvar'); ?>" method='post' class="form-horizontal">
                                <?php 
                                    $idMatricula = urlencode(base64_encode($arrMatricula['id_matricula']));
                                ?>
                                <input type="hidden" name="hddIdMatricula" value="<?php echo $idMatricula; ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Curso</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrMatricula['nome_curso']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Estágio *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltEstagio" id="sltEstagio" class="form-control">
                                                <option value="">Selecione o estágio</option>
                                                <?php
                                                    foreach ($arrInfoEstagio as $estagio)
                                                    {
                                                        $estagioSelecionado = $arrMatricula['id_estagio'] == $estagio['id_estagio'] ? "selected='selected'" : ''; 
                                                        echo "<option value='{$estagio['id_estagio']}' {$estagioSelecionado}>{$estagio['nome_estagio']}</option>".PHP_EOL;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Aluno</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrMatricula['nome_aluno']; ?>">
                                        </div>
                                    </div>
                                
                                    <?php 
                                        $arrDiaHoraSelecionado = array();

                                        foreach($arrMatriculaTurma as $turma)
                                        {
                                            $arrDiaHoraSelecionado[$turma['dia_aula']] = $turma['horario_aula_formatado'];
                                        }
                                    ?>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Dia/Hora Aula *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php  
                                                $arrDiasSelecionados = explode(',', $arrInfoUnidade['dias_semana']);

                                                foreach($arrDiasSelecionados as $dia)
                                                {
                                                    $diaSelecionado = '';
                                                    $horaInformada = '';
                                                    $display = 'none';
                                                    
                                                    if(isset($arrDiaHoraSelecionado[$dia]))
                                                    {
                                                        $diaSelecionado =  "checked='checked'";
                                                        $horaInformada = $arrDiaHoraSelecionado[$dia];
                                                        $display = 'inline';
                                                    }

                                                    echo " <label><input type='checkbox' name='chkDiaAula$dia' id='chkDiaAula$dia' value='{$dia}' class='flat chk-dia-aula' {$diaSelecionado}> {$dia} </label>";
                                                    echo " <input type='text' name='txtHoraAula$dia' id='txtHoraAula$dia' class='' style='display: {$display}; width: 60px;' value='{$horaInformada}' />";
                                                }
                                            ?>
                                            <span class="erro-dia"></span>
                                        </div>
                                    </div>                

                                    <div class='form-group'>
                                        <label for="txtDataMatricula" class='control-label col-md-3 col-sm-3 col-xs-12'>Data Matrícula *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtDataMatricula" id="txtDataMatricula" class="form-control <?php echo (form_error('txtDataMatricula') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtDataMatricula', $arrMatricula['data_matricula_formatada']); ?>" >
                                            <?php echo form_error('txtDataMatricula'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php 
                                                $statusAtiva = (int)$arrMatricula['ativo'] == 1 ? "checked='checked'" : '';
                                                $statusInativa = (int)$arrMatricula['ativo'] == 0 ? "checked='checked'" : '';
                                            ?>
                                            <label><input type='radio' class='flat' name='rdoStatusMatricula' id='rdoStatusAtiva' value='1' <?php echo $statusAtiva; ?> <?php echo set_radio('rdoStatusMatricula', '1'); ?>> Ativa</label><br />
                                            <label><input type='radio' class='flat' name='rdoStatusMatricula' id='rdoStatusInativa' value='0' <?php echo $statusInativa; ?> <?php echo set_radio('rdoStatusMatricula', '0'); ?>> Inativa</label>
                                        </div>	
                                    </div>

                                    <?php
                                        $displayDtInativa = 'none'; 
                                        if(!$arrMatricula['ativo'])
                                        {
                                            $displayDtInativa = 'block'; 
                                        }
                                    ?>

                                    <div id="divDataInativa" style="display: <?php echo $displayDtInativa; ?>;">
                                        <div class="form-group">
                                            <label for="txtDataInativa" class="control-label col-md-3 col-sm-3 col-xs-12">Data Inativa *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="txtDataInativa" name="txtDataInativa" class="form-control <?php echo (form_error('txtDataInativa') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtDataInativa', $arrMatricula['data_inativa_formatada']); ?>" >
                                                <?php echo form_error('txtDataInativa'); ?>
                                            </div>
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
    
        $("#rdoStatusAtiva").click(function () {
            var status = $(this).val();
            $("#divDataInativa").css('display', 'none');
        });

        $("#rdoStatusInativa").click(function () {
            var status = $(this).val();
            $("#divDataInativa").css('display', 'block');
        });
    
    </script>

</body>
</html>
