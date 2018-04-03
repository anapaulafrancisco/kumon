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
					Pessoa <small>Gerenciamento Pessoa</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('pessoa/gerenciar');?>"><i class="fa fa-graduation-cap"></i> Pessoa</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Pessoas</h3>

                        <div class="pull-right box-tools">
                            <a href='<?php echo base_url("pessoa/incluir"); ?>' class='btn btn-success btn-sm'><i class="fa fa-plus"></i> Incluir </a>
                        </div>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php echo Notificacao::getNotificacao(); ?>
                        
                        <table id="tbl-pessoa" class="table table-bordered table-striped dt-responsive">
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
                                
                                    foreach($arrPessoa as $pessoa) 
									{
                                        $pathVerPessoa = base_url("pessoa/ver/" .  urlencode(base64_encode($pessoa['id_pessoa']))); 
                                        $pathEditarPessoa = base_url("pessoa/editar/" .  urlencode(base64_encode($pessoa['id_pessoa']))); 
                                            
                                        $dataMysql = strtotime($pessoa['data_cadastro']); //usado para ordenacao correta no datatable
                                        $status = $pessoa['ativo'] ? 'Ativo' : 'Inativo';

                                        echo "<tr>
                                                <td>{$pessoa['nome_pessoa']}</td>
                                                <td>{$pessoa['email']}</td>
                                                <td data-search='{$pessoa['data_cadastro']}' data-order='{$dataMysql}'>{$pessoa['data_cadastro_formatada']}</td>
                                                <td>{$status}</td>
                                                <td>
                                                    <a href='{$pathVerPessoa}' class='btn btn-primary btn-xs'><i class='fa fa-search'></i> Ver</a>
                                                    <a href='{$pathEditarPessoa}' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Editar</a>                             
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
