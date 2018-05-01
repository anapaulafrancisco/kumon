<?php
getCabecalho();
$arrCredencial = get_credencial();

$fotoUsuario = 'foto_padrao.png';

if (!empty($arrUsuario['foto'])) {
    $fotoUsuario = $arrUsuario['foto'];
}

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
				<h1>Configuração</h1>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Informações do usuário</h3>
                            </div>

                            <form name="frmConfig" id="frmConfig" action="<?php echo base_url('usuario/usuario/alterarConfig'); ?>" method='post' class="form-horizontal" enctype="multipart/form-data">
                                <div class="box-body">
                                    
                                    <?php echo Notificacao::getNotificacao(); ?>  
                        
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Foto </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img src="<?php echo base_url('assets/uploads/perfil/') . $fotoUsuario; ?>" alt="" width="100">
                                        </div>
                                        <div class="clearfix"></div>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" name="flFoto" id="flFoto">
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="txtNome" class="control-label col-md-3 col-sm-3 col-xs-12">Nome </label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrUsuario['nome_usuario']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtEmail" class="control-label col-md-3 col-sm-3 col-xs-12">Email </label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrUsuario['email']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtUsuario" class="control-label col-md-3 col-sm-3 col-xs-12">Usuário </label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $arrUsuario['usuario']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Senha</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="password" name="pwdSenha" class="form-control <?php echo (form_error('pwdSenha') ? 'erro_formulario' : ''); ?>">
                                            <?php echo form_error('pwdSenha'); ?>
                                            
                                            <br />
                                            <p class="text-muted well well-sm no-shadow">
                                                Sua senha só será alterada, se você preencher este campo.
                                                Letras e números são obrigatórios. Mínimo 5 caracteres.
                                            </p>
                                        </div>
                                    </div>
          
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url('home'); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
                                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
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
