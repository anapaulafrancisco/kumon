<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();    
?>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('template_admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('template_admin/bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'); ?>">
    <!-- bootstrap select -->
    <link href="<?php echo base_url('assets/css/bootstrap-select.min.css'); ?>" rel="stylesheet">
  
    <style type="text/css">

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
					Horário <small>Gerenciamento Horário</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('horario/gerenciar');?>"><i class="fa fa-clock-o"></i> Horário</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filtro</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form name="frmFiltroRelatorio" id="frmFiltroRelatorio" action="<?php echo base_url($_SERVER['PATH_INFO']); ?>" method="POST">
                            <div class="row">
                                <div class='col-md-3 col-xs-12'>
                                    <label>Curso</label>
                                    <select name="sltCurso" id="sltCurso" class="form-control">
                                        <option value="">Selecione</option> 
                                        <?php 
                                            foreach ($arrCurso as $curso) 
                                            {
                                                $repopular = '';
                                                if($this->session->has_userdata('post_filtro_horario'))
                                                {						
                                                    $arrPost = $this->session->userdata('post_filtro_horario');
                                                    $repopular = $arrPost['sltCurso'] == $curso['id_curso'] ? "selected='selected'" : ''; 
                                                }

                                                echo "<option value='{$curso['id_curso']}' {$repopular} >{$curso['nome_curso']}</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>

                                <div class='col-md-5 col-xs-12'>
                                    <label>Aluno</label>
                                    <select name="sltAluno" id="sltAluno" class="form-control buscaAlunoCombo" data-live-search="true">
                                        <option value="">Selecione</option>
                                        <?php
                                            foreach ($arrAluno as $aluno) 
                                            {
                                                $repopular = '';
                                                if($this->session->has_userdata('post_filtro_horario'))
                                                {						
                                                    $arrPost = $this->session->userdata('post_filtro_horario');
                                                    $repopular = $arrPost['sltAluno'] == $aluno['id_aluno'] ? "selected='selected'" : ''; 
                                                }

                                                echo "<option value='{$aluno['id_aluno']}' {$repopular} >{$aluno['nome_aluno']}</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>

                                <div class='col-md-2 col-xs-12'>
                                    <label>Dia semana</label>
                                    <select name="sltDiaSemana" id="sltDiaSemana" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                            $arrDiasSelecionados = explode(',', $arrInfoUnidade['dias_semana']);

                                            foreach($arrDiasSelecionados as $dia)
                                            {
                                                $repopular = '';
                                                if($this->session->has_userdata('post_filtro_horario'))
                                                {						
                                                    $arrPost = $this->session->userdata('post_filtro_horario');
                                                    $repopular = $arrPost['sltDiaSemana'] == $dia ? "selected='selected'" : ''; 
                                                }

                                                echo "<option value='{$dia}' {$repopular} >{$dia}</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>

                            <div class='col-md-2 col-xs-12'>
                                <?php 
                                    $repopular = '';
                                    if($this->session->has_userdata('post_filtro_horario'))
                                    {						
                                        $arrPost = $this->session->userdata('post_filtro_horario');
                                        $repopular = $arrPost['txtHora']; 
                                    }
                                ?>
                                <label>Hora</label>
                                <input type="text" name="txtHora" id="txtHora" class="form-control" value="<?php echo $repopular; ?>" >
                            </div>

                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success" name='btnFiltrar' id='btnFiltrar'><i class="fa fa-filter"></i> Filtrar</button> &nbsp; 
                            <button class="btn btn-default" name='btnLimparFiltro'><i class="fa fa-trash-o"></i> Limpar Filtro</button>
                        </div>
                    </form>                                     
                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Horários</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php echo Notificacao::getNotificacao(); ?>

                        <table id="tbl-horario" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Aluno</th>
                                    <th>Dia/Hora Aula</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($arrInfoHorario as $info) 
									{
                                        echo "<tr>
                                                <td>{$info['nome_curso']}</td>
                                                <td>{$info['nome_aluno']}</td>
                                                <td>({$info['dia_hora_aula']})</td>
                                            </tr>";   
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
        
            </section>
			<!-- /.content -->
		</div>
        <!-- /.content-wrapper -->
                               
    <?php getRodape(); ?>

    <!-- DataTables -->
    <script src="<?php echo base_url('template_admin/bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('template_admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script> 
    <script src="<?php echo base_url('template_admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <!-- maskedinput (mascaras)-->
	<script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
    <!-- bootstrap select -->
    <script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>"></script>
    <!-- bootstrap select traducao-->
    <script src="<?php echo base_url('assets/js/i18n/defaults-pt_BR.min.js'); ?>"></script>

    <script>
        $(function () {
            $('#txtHora').mask('99:99');

            $('.buscaAlunoCombo').selectpicker();

            $('#tbl-horario').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json'
                },
                order: [[ 0, "asc" ], [ 1, 'asc' ]]
            });
        })
    </script>
</body>
</html>
