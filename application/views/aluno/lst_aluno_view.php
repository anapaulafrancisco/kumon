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
					Aluno <small>Gerenciamento Aluno</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('aluno/gerenciar');?>"><i class="fa fa-user"></i> Aluno</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Alunos</h3>

                        <div class="pull-right box-tools">
                            <a href='<?php echo base_url("aluno/incluir"); ?>' class='btn btn-success btn-sm'><i class="fa fa-plus"></i> Incluir </a>
                        </div>

                    </div>
                    

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tbl-aluno" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Cadastro</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    
                                    // echo "<pre>";
                                    // print_r ($arrAluno);
                                    // echo "</pre>";

                                    foreach($arrAluno as $aluno) 
									{
                                        $pathVerAluno = base_url("aluno/ver/" .  urlencode(base64_encode($aluno['id_aluno']))); 
                                        $pathEditarAluno = base_url("aluno/editar/" .  urlencode(base64_encode($aluno['id_aluno']))); 
                                            
                                        $dataMysql = strtotime($aluno['data_cadastro']); //usado para ordenacao correta no datatable
                                        $status = $aluno['ativo'] ? 'Ativo' : 'Inativo';

                                        echo "<tr>
                                                <td>{$aluno['nome_aluno']}</td>
                                                <td>{$aluno['email']}</td>
                                                <td data-search='{$aluno['data_cadastro']}' data-order='{$dataMysql}'>{$aluno['data_cadastro_formatada']}</td>
                                                <td>{$status}</td>
                                                <td>
                                                    <a href='{$pathVerAluno}' class='btn btn-primary btn-xs'><i class='fa fa-search'></i> Ver</a>
                                                    <a href='{$pathEditarAluno}' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Editar</a>                             
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
            $('#tbl-aluno').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json'
                }
            });
        })
    </script>
</body>
</html>
