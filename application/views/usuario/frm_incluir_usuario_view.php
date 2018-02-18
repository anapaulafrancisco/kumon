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
					Usuário
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('usuario/gerenciar');?>"><i class="fa fa-users"></i> Usuário</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <!-- left column -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Incluir Usuário</h3>
                            </div>

                            <?php echo Notificacao::getNotificacao(); ?>  

                            <form name="frmIncluirUsuario" id="frmIncluirUsuario" action="<?php echo base_url('usuario/incluir/salvar'); ?>" method='post' class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txtNome" class="control-label col-md-3 col-sm-3 col-xs-12">Nome *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="txtNome" name="txtNome" class="form-control <?php echo (form_error('txtNome') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNome'); ?>" >
                                            <?php echo form_error('txtNome'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtEmail" class="control-label col-md-3 col-sm-3 col-xs-12">Email *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="email" id="txtEmail" name="txtEmail" class="form-control <?php echo (form_error('txtEmail') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtEmail'); ?>" >
                                            <?php echo form_error('txtEmail'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtUsuario" class="control-label col-md-3 col-sm-3 col-xs-12">Usuário *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="txtUsuario" name="txtUsuario" class="form-control <?php echo (form_error('txtUsuario') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtUsuario'); ?>" >
                                            <?php echo form_error('txtUsuario'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwdSenha" class="control-label col-md-3 col-sm-3 col-xs-12">Senha *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="password" id="pwdSenha" name="pwdSenha" class="form-control <?php echo (form_error('pwdSenha') ? 'erro_formulario' : ''); ?>"  value="<?php echo set_value('pwdSenha'); ?>">
                                            <?php echo form_error('pwdSenha'); ?>
                                            <br />
                                            <p class="text-muted well well-sm no-shadow">
                                                Letras e números são obrigatórios. Mínimo 5 caracteres.
                                            </p>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Perfil <span class="required">*</span></label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php  
                                                // foreach($arrPerfil as $perfil)
                                                // {
                                                //     $repopular = set_checkbox('chkPerfil[]', $perfil['id_perfil']);

                                                //     echo "<div class='div-checkbox'>";
                                                //     echo " <label><input type='checkbox' name='chkPerfil[]' id='chkPerfil[]' value='{$perfil['id_perfil']}' class='flat' {$repopular}> {$perfil['perfil']}</label>";
                                                //     echo "</div>";
                                                // }

                                                // echo "<label class='error' for='chkPerfil[]' style='display: none;'></label>";
                                                // echo form_error('chkPerfil[]');	
                                                foreach($arrPerfil as $perfil)
                                                {
                                                    $repopular = set_radio('rdoPerfil', $perfil['id_perfil']);
                                                    echo "<label><input type='radio' class='flat' name='rdoPerfil' value='{$perfil['id_perfil']}' {$repopular}> {$perfil['perfil']}</label><br />";
                                                    
                                                }
                                                echo "<label class='error' for='rdoPerfil' style='display: none;'></label>";
                                                echo form_error('rdoPerfil');
                                      
                                            ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <label><input type='radio' class='flat' name='rdoStatusUsuario' value='1' <?php echo set_radio('rdoStatusUsuario', '1', TRUE); ?>> Ativo</label><br />
                                            <label><input type='radio' class='flat' name='rdoStatusUsuario' value='0' <?php echo set_radio('rdoStatusUsuario', '0'); ?>> Inativo</label>
                                        </div>	
                                    </div>
                                                    
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url("usuario/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
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

    <!--jquery.validate (validacao formulario)-->
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>

    <script>
        $(function() {
            $.validator.addMethod("regx", function(value, regexpr) {          
                return regexpr.test(value);
            }, "Senha fora do padrão. Letras e números são obrigatórios teste.");

            //VALIDACAO FORMULARIO
            $('#frmIncluirUsuario').validate({
                rules: {
                    txtNome: {
                        required: true,
                        minlength: 2
                    },
                    txtEmail: {
                        required: true,
                        email: true
                    },
                    txtUsuario: {
                        required: true,
                        minlength: 3
                    },
                    pwdSenha: {
                        required: true,
                        minlength: 5,
                        regx: '/([a-z]{1,})|([0-9]{1,})/'
                    },
                    rdoPerfil: { 
                        required: true
                    }
                },
                messages: {
                    txtNome: {
                        required: "O campo Nome é obrigatório",
                        minlength: "O campo Nome deve conter no mínimo 2 caracteres."
                    },
                    txtEmail: {
                        required: "O campo Email é obrigatório.",
                        email: "Informe um email válido."
                    },
                    txtUsuario: {
                        required: "O campo Usuário é obrigatório",
                        minlength: "O campo Usuário deve conter no mínimo 3 caracteres."
                    },
                    pwdSenha: {
                        required: "O campo Senha é obrigatório",
                        minlength: "O campo Senha deve conter no mínimo 5 caracteres."
                    },
                    rdoPerfil: {
                        required: "O campo Perfil é obrigatório."
                    }
                }
            });
        });
    </script>

</body>
</html>
