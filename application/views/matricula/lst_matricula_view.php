<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();    
?>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('template_admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('template_admin/bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'); ?>">

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
					Matrícula <small>Gerenciamento Matrícula</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('matricula/gerenciar');?>"><i class="fa fa-book"></i> Matrícula</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Matrículas</h3>

                        <div class="pull-right box-tools">
                            <a href='<?php echo base_url("matricula/incluir"); ?>' class='btn btn-success btn-sm'><i class="fa fa-plus"></i> Incluir </a>
                        </div>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php echo Notificacao::getNotificacao(); ?>
                        
                        <table id="tbl-matricula" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Aluno</th>
                                    <th>Data Matrícula</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                    foreach($arrMatricula as $matricula) 
									{
                                        $pathVerMatricula = base_url("matricula/ver/" .  urlencode(base64_encode($matricula['id_matricula']))); 
                                        $pathEditarMatricula = base_url("matricula/editar/" .  urlencode(base64_encode($matricula['id_matricula']))); 
                                            
                                        $dataMysql = strtotime($matricula['data_matricula']); //usado para ordenacao correta no datatable
                                        $status = $matricula['ativo'] ? 'Ativa' : 'Inativa';

                                        echo "<tr>
                                                <td>{$matricula['nome_curso']}</td>
                                                <td>{$matricula['nome_aluno']}</td>
                                                <td data-search='{$matricula['data_matricula']}' data-order='{$dataMysql}'>{$matricula['data_matricula_formatada']}</td>
                                                <td>{$status}</td>
                                                <td>
                                                    <a href='{$pathVerMatricula}' class='btn btn-primary btn-xs'><i class='fa fa-search'></i> Ver</a>
                                                    <a href='{$pathEditarMatricula}' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Editar</a>                             
                                                </td>
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
    
    <script>
        $(function () {
            $('#tbl-matricula').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json'
                }
            });
        })
    </script>
</body>
</html>
