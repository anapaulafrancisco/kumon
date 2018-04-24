<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();
?>

    <!-- bootstrap select -->
    <link href="<?php echo base_url('assets/css/bootstrap-select.min.css'); ?>" rel="stylesheet">

    <style type="text/css">
        input.error, textarea.error {
            background: #FAEDEC;
            border: 1px solid #E85445;
        }

        label.error{
            color: #E74C3C;
        }

        .buscaUsuarioCombo .btn-default{
            background-color: #FFFFFF !important; 
            color: #555 !important;
        }

        .btn dropdown-toggle btn-default bs-placeholder{
            color: 555;
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

                            <form name="frmUsuario" id="frmUsuario" action="<?php echo base_url('usuario/incluir/salvar'); ?>" method='post' class="form-horizontal">
                                <div class="box-body">
                                    
                                    <div class='form-group'>
                                        <label for="sltTipoUsuario" class='control-label col-md-3 col-sm-3 col-xs-12'>Tipo Usuário *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltTipoUsuario" id="sltTipoUsuario" class="form-control">
                                                 <option value="">Selecione</option>
                                                <?php 
                                                    foreach ($arrPerfil as $perfil) 
                                                    {
                                                        $repopular = set_select('sltTipoUsuario', $perfil['id_perfil']);
                                                        echo "<option value='{$perfil['id_perfil']}' {$repopular}>{$perfil['perfil']}</option>";
                                                    } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="sltNomeUsuario" class='control-label col-md-3 col-sm-3 col-xs-12'>Nome *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltNomeUsuario" id="sltNomeUsuario" class="form-control buscaUsuarioCombo" data-live-search="true">
                                                <option value="">Selecione o tipo</option>
                                            </select>

                                            <input type="hidden" id="hddNomeUsuario" name="hddNomeUsuario" />
                                        </div>
                                    </div>  
                                    
                                    <div class="form-group">
                                        <label for="txtEmail" class="control-label col-md-3 col-sm-3 col-xs-12">Email *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="email" id="txtEmail" name="txtEmail" class="form-control <?php echo (form_error('txtEmail') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtEmail'); ?>" readonly>
                                            <?php echo form_error('txtEmail'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtUsuario" class="control-label col-md-3 col-sm-3 col-xs-12">Usuário *</label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="txtUsuario" name="txtUsuario" class="form-control <?php echo (form_error('txtUsuario') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtUsuario'); ?>">
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

                                    <!-- <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Perfil *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <?php  
           
                                                /* foreach($arrPerfil as $perfil)
                                                {
                                                    $repopular = set_radio('rdoPerfil', $perfil['id_perfil']);
                                                    echo "<label><input type='radio' class='flat' name='rdoPerfil' value='{$perfil['id_perfil']}' {$repopular}> {$perfil['perfil']}</label><br />";
                                                    
                                                }
                                                echo "<label class='error' for='rdoPerfil' style='display: none;'></label>";
                                                echo form_error('rdoPerfil'); */
                                      
                                            ?>
                                        </div>
                                    </div> -->

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
    <!-- bootstrap select -->
    <script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>"></script>
    <!-- bootstrap select traducao-->
    <script src="<?php echo base_url('assets/js/i18n/defaults-pt_BR.min.js'); ?>"></script>
    <!--regras usuario-->
    <script src="<?php echo base_url('assets/js/usuario.js'); ?>"></script>

    <script>
        $(function() {

            /* $('.buscaUsuarioCombo').selectpicker();

            $('#txtUsuario').keyup(function(){
                $(this).val($(this).val().toLowerCase());
            }); */
            
            //exibe combo de nome usuario (aluno/auxiliar) de acordo com o tipo de usuario
            $("#sltTipoUsuario").change(function () {
                var idTipoUsuario = $(this).val();

                $.post(
                    "<?php echo base_url() ?>ajax/usuarioAjax/buscaUsuarioSistema",
                    { idTipoUsuario: idTipoUsuario },
                    function (usuarios) {
                        $("#sltNomeUsuario").html(usuarios);
                        $("#sltNomeUsuario").selectpicker('refresh');
                        $("#txtEmail").val('');
                        $("#hddNomeUsuario").val('');
                        $("#txtUsuario").val('');
                    }
                );
            });   

            //exibe o email do usuario sistema selecionado
            $("#sltNomeUsuario").change(function(){
                var idUsuarioSistema = $(this).val();
                var idTipoUsuario = $("#sltTipoUsuario").val();
                var nomeUsuario = $('#sltNomeUsuario :selected').text();
          
                $.post(
                    "<?php echo base_url() ?>ajax/usuarioAjax/buscaEmailUsuarioSistema", 
                    { 
                        idUsuarioSistema: idUsuarioSistema,
                        idTipoUsuario: idTipoUsuario
                    }, 
                    function(infoUsuario){
                        $("#txtEmail").val(infoUsuario.email);
                        $("#hddNomeUsuario").val(nomeUsuario);
                        $("#txtUsuario").val(infoUsuario.identificador_aluno);
                    }, 'json'
                );
            });		

        });
    </script>

</body>
</html>
