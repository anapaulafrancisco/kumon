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
					Dashboard <small>Painel de controle</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">    
				<div class="row">
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-green">
							<div class="inner">
								<h3><?php echo $qtdeAluno; ?></h3>
								<p>Qtde Aluno</p>
							</div>
							<div class="icon">
								<i class="fa fa-user-plus"></i>
							</div>
							<a href="#" class="small-box-footer">Cadastrar <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3>0</h3>
								<p>Qtde Matrícula</p>
							</div>
							<div class="icon">
								<i class="fa fa-edit"></i>
							</div>
							<a href="#" class="small-box-footer">Matricular <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
				</div>
				<!-- /.row -->

			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

  <?php getRodape(); ?>
</body>
</html>
