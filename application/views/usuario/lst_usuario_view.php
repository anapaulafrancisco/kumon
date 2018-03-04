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
					Usuário <small>Gerenciamento Usuário</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('usuario/gerenciar');?>"><i class="fa fa-users"></i> Usuário</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Usuários</h3>

                        <div class="pull-right box-tools">
                            <a href='<?php echo base_url("usuario/incluir"); ?>' class='btn btn-success btn-sm'><i class="fa fa-plus"></i> Incluir </a>
                        </div>

                    </div>
                    
                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php echo Notificacao::getNotificacao(); ?>  

                        <table id="tbl-usuario" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Usuário</th>
                                    <th>Perfil</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
              
                                    foreach($arrUsuario as $usuario) 
									{
                                        $pathVerUsuario = base_url("usuario/ver/" .  urlencode(base64_encode($usuario['id_usuario']))); 
                                        $pathEditarUsuario = base_url("usuario/editar/" .  urlencode(base64_encode($usuario['id_usuario']))); 
                                            
                                        $dataMysql = strtotime($usuario['data_cadastro']); //usado para ordenacao correta no datatable
                                        $status = $usuario['ativo'] ? 'Ativo' : 'Inativo';

                                        echo "<tr>
                                                <td>{$usuario['nome_usuario']}</td>
                                                <td>{$usuario['email']}</td>
                                                <td>{$usuario['usuario']}</td>
                                                <td>{$usuario['perfis']}</td>
                                                <td>{$status}</td>
                                                <td>
                                                    <a href='{$pathVerUsuario}' class='btn btn-primary btn-xs'><i class='fa fa-search'></i> Ver</a>
                                                    <a href='{$pathEditarUsuario}' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Editar</a>                             
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
            $('#tbl-usuario').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json'
                }
            });
        })
    </script>
</body>
</html>
