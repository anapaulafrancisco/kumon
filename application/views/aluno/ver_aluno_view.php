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
					Aluno
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('aluno/gerenciar');?>"><i class="fa fa-user"></i> Aluno</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Ver Aluno</h3>
                            </div>

                            <form class="form-horizontal">
                                <div class="box-body">

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Identificador Aluno</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['identificador_aluno']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['nome_aluno']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['email']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>CPF</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['cpf']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Data Nascimento</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['data_nascimento_formatada']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Idade</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtIdade" id="txtIdade" class="form-control" value="<?php echo $arrAluno['idade']; ?>" disabled>
                                        </div>
                                    </div>
                                    
                                    <?php $blocoResponsavel = $arrAluno['idade'] < 18 ? "style='display: block;'" : "style='display: none;'"; ?>

                                    <div id="div-responsavel" <?php echo $blocoResponsavel; ?>>
                                        <div class='form-group'>
                                            <label class='control-label col-md-3 col-sm-3 col-xs-12'>Nome responsável</label>
                                            <div class='col-md-6 col-sm-6 col-xs-12'>
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['nome_responsavel']; ?>">
                                            </div>
                                        </div>

                                        <div class='form-group'>
                                            <label class='control-label col-md-3 col-sm-3 col-xs-12'>CPF responsável</label>
                                            <div class='col-md-6 col-sm-6 col-xs-12'>
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['cpf_responsavel']; ?>">
                                            </div>
                                        </div>
                                    </div>    

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Sexo </label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php $sexo = $arrAluno['sexo'] == 'M' ? 'Masculino' : 'Feminino'; ?>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $sexo; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Celular</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                           <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['celular']; ?>">
                                        </div>
                                    </div>
                                        
                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Telefone Residencial</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['telefone']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Série</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['nome_serie']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>CEP</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                           <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['cep']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Endereço</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['endereco']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Bairro</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['bairro']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Cidade</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['cidade']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Estado</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrAluno['estado']; ?>">
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php $status = $arrAluno['ativo'] ? 'Ativo' : 'Inativo'; ?>
								            <input type="text" class="form-control" disabled="disabled" value="<?php echo $status; ?>">
                                        </div>	
                                    </div>
                                                    
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url("aluno/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div><!-- /.box -->
                    </div><!-- /div cols -->
                </div><!-- /div row -->
            </section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

    <?php getRodape(); ?>

</body>
</html>
