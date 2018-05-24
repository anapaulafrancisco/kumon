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
					Curso <small>Gerenciamento Curso</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('curso/gerenciar');?>"><i class="fa fa-folder-open"></i> Curso</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Cursos</h3>

                        <div class="pull-right box-tools">
                            <a href='<?php echo base_url("curso/incluir"); ?>' class='btn btn-success btn-sm'><i class="fa fa-plus"></i> Incluir </a>
                        </div>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php echo Notificacao::getNotificacao(); ?>
                        
                        <table id="tbl-pessoa" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Cadastro</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                    foreach($arrCurso as $curso) 
									{
                                        $pathVerEstagio = base_url("curso/ver/estagio/" .  urlencode(base64_encode($curso['id_curso']))); 
                                        $pathEditarCurso = base_url("curso/editar/" .  urlencode(base64_encode($curso['id_curso']))); 
                                            
                                        $dataMysql = strtotime($curso['data_curso']); //usado para ordenacao correta no datatable
                                        $status = $curso['ativo'] ? 'Ativo' : 'Inativo';

                                        echo "<tr>
                                                <td>{$curso['nome_curso']}</td>
                                                <td data-search='{$curso['data_curso']}' data-order='{$dataMysql}'>{$curso['data_curso_formatada']}</td>
                                                <td>{$status}</td>
                                                <td>
                                                    <a href='{$pathVerEstagio}' class='btn btn-primary btn-xs'><i class='fa fa-search'></i> Ver Estágios</a>
                                                    <a href='{$pathEditarCurso}' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Editar Curso</a>                             
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
            $('#tbl-pessoa').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json'
                }
            });
        })
    </script>
</body>
</html>
