<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();    
?>
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
					Relatório <small>Saldo de alunos</small>
				</h1>
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
                                    <label>Mês</label>
                                    <select name="sltMes" id="sltMes" class="form-control">
                                        <option value="">Selecione</option> 
                                        <?php 
                                            foreach ($arrMes as $indice => $mes) 
                                            {
                                                $repopular = '';
                                                if($this->session->has_userdata('post_filtro'))
                                                {						
                                                    $arrPost = $this->session->userdata('post_filtro');
                                                    $repopular = $arrPost['sltMes'] == $indice ? "selected='selected'" : ''; 
                                                }

                                                echo "<option value='{$indice}' {$repopular} >{$mes}</option>";
                                            } 
                                        ?>
                                    </select>
                                </div>

                                <div class='col-md-2 col-xs-12'>
                                    <?php 
                                        $repopular = date('Y');
                                        if($this->session->has_userdata('post_filtro'))
                                        {						
                                            $arrPost = $this->session->userdata('post_filtro');
                                            $repopular = $arrPost['txtAno']; 
                                        }
                                    ?>
                                    <label>Ano</label>
                                    <input type="text" name="txtAno" id="txtAno" class="form-control" value="<?php echo $repopular; ?>" />
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

                <?php if(!is_null($mesAnoSelecionado) && ($arrSaldoAlunoAtivoMes || $arrSaldoAlunoInativoMes)): ?>
                <div class="box">
                    <div class="box-header">
                        <!-- <h4 class="box-title">Saldo de alunos</h4> -->

                        <div class="pull-right box-tools">
                            <button class="btn btn-default" name='btnLimparFiltro' id='btn-imprimir'><i class="fa fa-print"></i> Imprimir</button>
                        </div>
                        <!-- <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body div-imprimir">

                        <h3>Relatório - Saldo de Alunos</h3>
                        <h4>Mês de <?php echo $mesAnoSelecionado; ?></h4><br /> 
                        <?php 
                            if($arrSaldoAlunoAtivoMes):
                                $labelAlunoSaida = $totalEntrada > 1 ? 'alunos' : 'aluno';
                        ?>                    
                            <h4>Entrada do mês: <?php echo $totalEntrada . ' ' . $labelAlunoSaida; ?></h4><br /> 
                        <?php 
                            foreach($arrSaldoAlunoAtivoMes as $curso => $arrInfoAluno):
                        ?>
                            <h4>Curso: <?php echo $curso; ?></h4>
                            <table class="table">
                                <tr>
                                    <th width='50%'>Nome</th>
                                    <th>Data matrícula</th>
                                </tr>
                                <?php 
                                    $i = 0;
                                    foreach ($arrInfoAluno as $info) 
                                    {
                                        $i++;
                                        echo "<tr>
                                                <td>{$info['nome_aluno']}</td>
                                                <td>{$info['data_matricula_formatada']}</td>
                                            </tr>";
                                        
                                    }
                                    echo "<tr><td colspan='2'><h4>Total: {$i}</h4></tr>";  
                                   
                                ?>
                            </table>
                        <?php endforeach; ?>

                        <!-- <h2>Total de alunos da unidade: <?php //echo $totalEntrada; ?></h2>       -->

                        <?php endif; ?>    

                        <?php 
                            if($arrSaldoAlunoInativoMes): 
                            
                                $labelAlunoSaida = $totalSaida > 1 ? 'alunos' : 'aluno';
                        ?>                    
                            <!-- <h2>Saída do mês de <?php //echo $mesAnoSelecionado . ': ' . $totalEntrada; ?></h2>  -->
                            
                            <br /> <h4>Saída do mês: <?php echo $totalSaida . ' ' . $labelAlunoSaida; ?></h4><br /> 
                        <?php 
                            foreach($arrSaldoAlunoInativoMes as $curso => $arrInfoAluno):
                        ?>
                            <h4>Curso: <?php echo $curso; ?></h4>
                            <table class="table">
                                <tr>
                                    <th width='50%'>Nome</th>
                                    <th>Data inativo</th>
                                </tr>
                                <?php 
                                    $i = 0;
                                    foreach ($arrInfoAluno as $info) 
                                    {
                                        $i++;
                                        echo "<tr>
                                                <td>{$info['nome_aluno']}</td>
                                                <td>{$info['data_inativo_formatada']}</td>
                                            </tr>";
                                        
                                    }
                                    echo "<tr><td colspan='2'><h4>Total: {$i}</h4></tr>";  
                                   
                                ?>
                            </table>
                        <?php endforeach; ?>

                        <!-- <h2>Total de alunos da unidade: <?php //echo $totalEntrada; ?></h2>       -->

                        <?php endif; ?> 
                    </div>
                    <!-- /.box-body -->
                    
                </div>
                <!-- /.box -->                      
                <?php else: ?> 
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
                        Saldo de alunos não foi encontrado.
                    </div>
                <?php endif; ?>
        
            </section>
			<!-- /.content -->
		</div>
        <!-- /.content-wrapper -->
                               
    <?php getRodape(); ?>

    <!-- maskedinput (mascaras)-->
	<script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
    <!--jquery.validate (validacao formulario)-->
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
    <!-- impressao -->
    <script src="<?php echo base_url('assets/js/printThis.js'); ?>"></script>
  
    <script>
        $(function () {
            $('#txtAno').mask('9999');
            
            //VALIDACAO FORMULARIO
            $('#frmFiltroRelatorio').validate({
                rules: {
                    sltMes: {
                        required: true
                    },
                    txtAno: {
                        required: true
                    }
                },
                messages: {
                    sltMes: {
                        required: "O campo Mês é obrigatório"
                    },
                    txtAno: {
                        required: "O campo Ano é obrigatório."
                    }
                }
            });

             $('#btn-imprimir').on("click", function () {
                $('.div-imprimir').printThis();
            });

        })
    </script>
</body>
</html>
