<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();    
	
	$arrPerfilNome = explode(',', $arrCredencial['perfis_nomes']);

	$fotoPerfil = 'foto_padrao.png';

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

			<?php if(!in_array('aluno', $arrPerfilNome)): ?>

			<section class="content">    
				<div class="row">
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-green">
							<div class="inner">
								<h3><?php echo $qtdeAluno; ?></h3>
								<p>Qtde aluno ativo</p>
							</div>
							<div class="icon">
								<i class="fa fa-user-plus"></i>
							</div>
							<a href="<?php echo base_url('aluno/incluir');?>" class="small-box-footer">Cadastrar <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3><?php echo $qtdeMatricula; ?></h3>
								<p>Qtde matrícula ativa</p>
							</div>
							<div class="icon">
								<i class="fa fa-book"></i>
							</div>
							<a href="<?php echo base_url('matricula/incluir');?>" class="small-box-footer">Matricular <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-yellow">
							<div class="inner">
								<h3><?php echo $qtdeAuxiliarAtivo; ?></h3>
								<p>Qtde Auxiliar ativo</p>
							</div>
							<div class="icon">
								<i class="fa fa-edit"></i>
							</div>
							<a href="<?php echo base_url('pessoa/incluir');?>" class="small-box-footer">Cadastrar <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-red">
							<div class="inner">
								<h3><?php echo $qtdeMatriculaInativa; ?></h3>
								<p>Qtde matrícula inativa no ano</p>
							</div>
							<div class="icon">
								<i class="fa fa-book"></i>
							</div>
							<a href="#" class="small-box-footer"> <i class="fa fa-exclamation"></i></a>
						</div>
					</div>
					<!-- ./col -->
				</div>
				<!-- /.row -->

				<?php 
					echo "<table id='dadosRelEntradaSaida' style='display:none;'>
									<thead>
										<tr>
											<th></th>
											<th>matrículas ativas</th>
											<th>matrículas inativas</th>
										</tr>
									</thead>
									<tbody>";   
										foreach ($graficoEntradaSaida as $grafico) 
										{
											echo "<tr>
													<th>{$grafico['mes']}</th>
													<td>{$grafico['total_ativo']}</td>
													<td>{$grafico['total_inativo']}</td>
												</tr>";
										}
							echo " </tbody>
								</table>";
				?>

				<!-- grafico entrada/saida alunos ultimos 12 meses-->
				<div id="graficoEntradaSaida" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

			</section>

			<?php endif; ?>

			<?php if(in_array('aluno', $arrPerfilNome)): ?>
				<section class="content">    
					<div class="row">
						<div class="col-lg-3 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-green">
								<div class="inner">
									<h3><?php echo $qtdeCursoAluno; ?></h3>
									<p>Quantidade curso</p>
								</div>
								<div class="icon">
									<i class="fa fa-book"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-aqua">
								<div class="inner">
									<h3><?php echo $arrInfoMatriculaAluno[0]['nome_serie']; ?></h3>
									<p><?php echo $arrInfoMatriculaAluno[0]['nivel']; ?></p>
								</div>
								<div class="icon">
									<i class="fa fa-mortar-board"></i>
								</div>
							</div>
						</div>
					</div>		

					<div class="box box-primary">
                    	<div class="box-header with-border">
                   		 	<h3 class="box-title">Informações Matrícula - <?php echo $arrInfoMatriculaAluno[0]['nome_aluno']; ?></h3>
                    	</div>
                    	<!-- /.box-header -->
						<div class="box-body">							
							<table class="table table-bordered">
								<tr>
									<th>Curso</th>
									<th>Data Matrícula</th>
									<th>Dia/Hora Aula</th>
								</tr>
								<?php 
									foreach ($arrInfoMatriculaAluno as $infoMatricula) 
									{
										echo "<tr>
												<td>{$infoMatricula['nome_curso']}</td>
												<td>{$infoMatricula['data_matricula_formatada']}</td>
												<td>({$infoMatricula['dia_hora_aula']})</td>
											</tr>";
									}
								?>
							</table>
						</div>
                    	<!-- /.box-body -->
                  	</div>

				</section>

			<?php endif; ?>

			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

  <?php getRodape(); ?>
	
	<script src="<?php echo base_url('assets/js/highcharts/highcharts.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/highcharts/modules/data.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/highcharts/modules/exporting.js'); ?>"></script>

	<script>

		Highcharts.setOptions({
            lang: {
                loading: ['Atualizando o gráfico...aguarde'],
                contextButtonTitle: 'Exportar gráfico',
                decimalPoint: ',',
                thousandsSep: '.',
                downloadJPEG: 'Baixar imagem JPEG',
                downloadPDF: 'Baixar arquivo PDF',
                downloadPNG: 'Baixar imagem PNG',
                downloadSVG: 'Baixar vetor SVG',
                printChart: 'Imprimir gráfico',
                rangeSelectorFrom: 'De',
                rangeSelectorTo: 'Para',
                rangeSelectorZoom: 'Zoom',
                resetZoom: 'Limpar Zoom',
                resetZoomTitle: 'Voltar Zoom para nível 1:1',
            }
        });

		Highcharts.chart('graficoEntradaSaida', {
			data: {
				table: 'dadosRelEntradaSaida'
			},
			chart: {
			type: 'line'
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
			title: {
				text: 'Total entrada e saída alunos - Últimos 12 meses'
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'Qtde'
				}
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
						this.point.y + ' ' + this.point.name.toLowerCase();
				}
			}
		});

	</script>

</body>
</html>
