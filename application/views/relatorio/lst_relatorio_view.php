<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();    
?>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('template_admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('template_admin/bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'); ?>">

    <style type="text/css">
        input.error, textarea.error {
            background: #FAEDEC;
            border: 1px solid #E85445;
        }

        label.error{
            color: #E74C3C;
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
					Relatório <small>Histórico estudo</small>
				</h1>
			</section>

			<!-- Main content -->
			<section class="content">
                    <?php
               
                        if(isset($arrInfoRelFolhaMes) && in_array('ok',$arrInfoRelFolhaMes))
                        {
                            echo "<table id='dadosRel' style='display:none;'>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>folhas</th>
                                        </tr>
                                    </thead>
                                    <tbody>";   
                                        foreach ($arrInfoRelFolhaMes['info'] as $rel) 
                                        {
                                            echo "<tr>
                                                    <th>{$rel['mes']}</th>
                                                    <td>{$rel['qtde_folhas']}</td>
                                                </tr>";
                                        }
                            echo " </tbody>
                                </table>";        
                        }
                 
                        if(isset($arrInfoRelFolhaMes) && in_array('erro',$arrInfoRelFolhaMes))
                        {
                    ?>
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
                                Nenhum histórico de estudo foi encontrado.
                            </div>
                    <?php
                        }
                    ?>

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
                                                    if($this->session->has_userdata('post_filtro'))
                                                    {						
                                                        $arrPost = $this->session->userdata('post_filtro');
                                                        $repopular = $arrPost['sltCurso'] == $curso['id_curso'] ? "selected='selected'" : ''; 
                                                    }

                                                    echo "<option value='{$curso['id_curso']}' {$repopular} >{$curso['nome_curso']}</option>";
                                                } 
                                            ?>
                                        </select>
                                    </div>

                                    <div class='col-md-3 col-xs-12'>
                                        <label>Aluno</label>
                                        <select name="sltAluno" id="sltAluno" class="form-control">
                                            <option value="">Selecione o curso</option>
                                            <?php
                                                if($arrInfoAluno)
                                                {
                                                    foreach ($arrInfoAluno as $aluno)
                                                    {
                                                        $repopular = '';
                                                        if($this->session->has_userdata('post_filtro'))
                                                        {						
                                                            $arrPost = $this->session->userdata('post_filtro');
                                                            $repopular = $arrPost['sltAluno'] == $aluno['id_aluno'] ? "selected='selected'" : ''; 
                                                        }

                                                        echo "<option value='{$aluno['id_aluno']}' {$repopular}>{$aluno['nome_aluno']}</option>".PHP_EOL;
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>

                                     <div class='col-md-3 col-xs-12'>
                                        <label>Período</label>
                                        <select name="sltPeriodo" id="sltPeriodo" class="form-control">
                                            <?php
                                                for($i = 1; $i <= 12; $i++)
                                                {
                                                    $repopular = '';
                                                    if($this->session->has_userdata('post_filtro'))
                                                    {						
                                                        $arrPost = $this->session->userdata('post_filtro');
                                                        $repopular = $arrPost['sltPeriodo'] == $i ? "selected='selected'" : ''; 
                                                    }

                                                   $labelMes = $i == 1 ? 'mês' : 'meses';
                                                   echo "<option value='{$i}' {$repopular}> {$i} {$labelMes} </option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success" name='btnFiltrar' id='btnFiltrar'><i class="fa fa-filter"></i> Filtrar</button> &nbsp; 
                                <!-- <button class="btn btn-success" name='btnFiltrar' id='btnFiltrar'><i class="fa fa-filter"></i> Filtrar</button> &nbsp;  -->
                                <button class="btn btn-default" name='btnLimparFiltro'><i class="fa fa-trash-o"></i> Limpar Filtro</button>
                            </div>
                        </form>                                     

                    </div>
                    <!-- /.box -->
                <!-- /.col -->

                <!-- div de exibicao do grafico -->  
                <?php if(isset($arrInfoRelFolhaMes) && in_array('ok',$arrInfoRelFolhaMes)) : ?>                              
                <div class="box box-primary"><div id="graficoFolhaMes" style="min-width: 400px; height: 400px; margin: 0 auto"></div></div>
                
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $arrInfoRelFolhaMes['info'][0]['nome_aluno'] . ' - ' . $arrInfoRelFolhaMes['info'][0]['serie'] . ' - ' . $arrInfoRelFolhaMes['info'][0]['periodo']; ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Mês</th>
                            <th>Ano</th>
                            <th>Estágio - folhas</th>
                        </tr>
                        <?php 
                            foreach ($arrInfoRelFolhaMes['info'] as $info) 
                            {
                                echo "<tr>
                                        <td>{$info['mes']}</td>
                                        <td>{$info['ano']}</td>
                                        <td>{$info['info_estagio']}</td>
                                    </tr>";
                            }
                        ?>
                    </table>
                    </div>
                    <!-- /.box-body -->
                    
                </div>
                <!-- /.box -->
      
                <?php endif; ?>                                        



            </section>
			<!-- /.content -->
		</div>
        <!-- /.content-wrapper -->

    <?php getRodape(); ?>

    <!-- highcharts -->
    <script src="<?php echo base_url('assets/js/highcharts/highcharts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/highcharts/modules/data.js'); ?>"></script>
    <!-- <script src="<?php //echo base_url('assets/js/highcharts/modules/series-label.js'); ?>"></script> -->
    <script src="<?php echo base_url('assets/js/highcharts/modules/exporting.js'); ?>"></script>

    <!--jquery.validate (validacao formulario)-->
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>

    <script>
        //exibe combo de aluno de acordo com o curso
        $("#sltCurso").change(function(){
            var idCurso = $(this).val();
         
            $.post(
                "<?php echo base_url() ?>ajax/alunoAjax/buscaAluno", 
                { idCurso : idCurso }, 
                function(alunos){
                    $("#sltAluno").html(alunos);
                }
            );
        });

        //VALIDACAO FORMULARIO
        $('#frmFiltroRelatorio').validate({
            rules: {
                sltCurso: {
                    required: true
                },
                sltAluno: {
                    required: true
                }
            },
            messages: {
                sltCurso: {
                    required: "O campo Curso é obrigatório"
                },
                sltAluno: {
                    required: "O campo Aluno é obrigatório."
                }
            }
        });


        Highcharts.setOptions({
            lang: {
                months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                shortMonths: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
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

        //$('#graficoFolhaMes').highcharts({
        Highcharts.chart('graficoFolhaMes', {
            legend: {
                enabled: false
            },
            data: {
                table: 'dadosRel'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Folhas por mês'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Qtde folhas'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:14px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0"><b> {point.y:.0f}</b></td>' +
                                '<td>&nbsp;<td>'+    
                                '<td style="color:{series.color};padding:0">{series.name}</td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            }
        });


    </script>
</body>
</html>
