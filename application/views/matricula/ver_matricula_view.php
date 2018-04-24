<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();    
?>

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
                                <h3 class="box-title">Ver Matricula Aluno</h3>
                            </div>

                            <form class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Curso</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrMatricula['nome_curso']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Estágio</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrMatricula['nome_estagio']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Aluno</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrMatricula['nome_aluno']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Dia/Hora Aula</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php 
                                                foreach($arrMatriculaTurma as $turma)
                                                {
                                                    echo "<input type='text' class='form-control' disabled='disabled' value='{$turma['dia_aula']}  - {$turma['horario_aula_formatado']}'>";
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Data Matrícula</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrMatricula['data_matricula_formatada']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php $status = $arrMatricula['ativo'] ? 'Ativa' : 'Inativa'; ?>
								            <input type="text" class="form-control" disabled="disabled" value="<?php echo $status; ?>">
                                        </div>	
                                    </div>
                                                    
                                    <?php if(!$arrMatricula['ativo']): ?>                
                                        <div class="form-group">
                                            <label for="txtDataInativo" class="control-label col-md-3 col-sm-3 col-xs-12">Data Inativa</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrMatricula['data_inativa_formatada']; ?>" >
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url("matricula/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
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

</body>
</html>
