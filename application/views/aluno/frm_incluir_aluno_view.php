<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();

    $arrEstado = array('AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SE', 'SP', 'TO');
?>

    <!-- jquery-ui CSS-->
    <link href="<?php echo base_url('assets/css/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet">

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
                                <h3 class="box-title">Incluir Aluno</h3>
                            </div>

                            <?php echo Notificacao::getNotificacao(); ?>  

                            <form name="frmAluno" id="frmAluno" action="<?php echo base_url('aluno/incluir/salvar'); ?>" method='post' class="form-horizontal">
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

                                    <div class='form-group'>
                                        <label for="txtCPF"  class='control-label col-md-3 col-sm-3 col-xs-12'>CPF *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCPF" id="txtCPF" class="form-control <?php echo (form_error('txtCPF') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCPF'); ?>">
                                            <?php echo form_error('txtCPF'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtDtNasc" class='control-label col-md-3 col-sm-3 col-xs-12'>Data Nascimento *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                                <input type="text" name="txtDtNasc" id="txtDtNasc" class="form-control <?php echo (form_error('txtDtNasc') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtDtNasc'); ?>" >
                                                <?php echo form_error('txtDtNasc'); ?>
                                        </div>
                                    </div>
                                    
                                    <div class='form-group'>
                                        <label for="txtIdade" class='control-label col-md-3 col-sm-3 col-xs-12'>Idade</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtIdade" id="txtIdade" class="form-control" disabled>
                                        </div>
                                    </div>

                                    <div id="div-responsavel" style="display: none;">
                                        <div class='form-group'>
                                            <label for="txtNomeResponsavel"  class='control-label col-md-3 col-sm-3 col-xs-12'>Nome responsável *</label>
                                            <div class='col-md-6 col-sm-6 col-xs-12'>
                                                <input type="text" name="txtNomeResponsavel" id="txtNomeResponsavel" class="form-control <?php echo (form_error('txtNomeResponsavel') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtNomeResponsavel'); ?>">
                                                <?php echo form_error('txtNomeResponsavel'); ?>
                                            </div>
                                        </div>

                                        <div class='form-group'>
                                            <label for="txtCPFResponsavel"  class='control-label col-md-3 col-sm-3 col-xs-12'>CPF responsável *</label>
                                            <div class='col-md-6 col-sm-6 col-xs-12'>
                                                <input type="text" name="txtCPFResponsavel" id="txtCPFResponsavel" class="form-control <?php echo (form_error('txtCPFResponsavel') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCPFResponsavel'); ?>">
                                                <?php echo form_error('txtCPFResponsavel'); ?>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Sexo </label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <label><input type="radio" class="flat" name="rdoSexo" value="M" checked="checked" /> Masculino </label>
                                            <label><input type="radio" class="flat" name="rdoSexo" value="F" /> Feminino </label>
                                        </div>
                                    </div>
                                    
                                    <div class='form-group'>
                                        <label for="txtCelular" class='control-label col-md-3 col-sm-3 col-xs-12'>Celular</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCelular" id="txtCelular" class="form-control <?php echo (form_error('txtCelular') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCelular'); ?>">
                                            <?php echo form_error('txtCelular'); ?>
                                        </div>
                                    </div>
                                        
                                    <div class='form-group'>
                                        <label for="txtTelResidencial" class='control-label col-md-3 col-sm-3 col-xs-12'>Telefone Residencial *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtTelResidencial" id="txtTelResidencial" class="form-control <?php echo (form_error('txtTelResidencial') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtTelResidencial'); ?>">
                                            <?php echo form_error('txtTelResidencial'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtEstado" class='control-label col-md-3 col-sm-3 col-xs-12'>Série *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltSerie" id="sltSerie" class="form-control" >
                                            <option value="">Selecione</option>
                                                <?php 

                                                    foreach($arrInfoSerie as $nivel => $serie)
                                                    {
                                                        echo "<optgroup label='{$nivel}'>";
                                                        foreach($serie as $idSerie => $nomeSerie)
                                                        {
                                                            $repopular = set_select('sltSerie', $idSerie);
                                                            echo "<option value='{$idSerie}' {$repopular} >{$nomeSerie}</option>";
                                                        }
                                                        echo "</optgroup>";
                                                    }
                                                
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class='form-group'>
                                        <label for="txtCEP" class='control-label col-md-3 col-sm-3 col-xs-12'>CEP *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCEP" id="txtCEP" class="form-control <?php echo (form_error('txtCEP') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCEP'); ?>" >
                                            <?php echo form_error('txtCEP'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtEndereco" class='control-label col-md-3 col-sm-3 col-xs-12'>Endereço *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtEndereco" id="txtEndereco" class="form-control <?php echo (form_error('txtEndereco') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtEndereco'); ?>" >
                                            <?php echo form_error('txtEndereco'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtBairro" class='control-label col-md-3 col-sm-3 col-xs-12'>Bairro *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtBairro" id="txtBairro" class="form-control <?php echo (form_error('txtBairro') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtBairro'); ?>" >
                                            <?php echo form_error('txtBairro'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="txtCidade" class='control-label col-md-3 col-sm-3 col-xs-12'>Cidade *</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <input type="text" name="txtCidade" id="txtCidade" class="form-control <?php echo (form_error('txtCidade') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtCidade'); ?>" >
                                            <?php echo form_error('txtCidade'); ?>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="sltEstado" class='control-label col-md-3 col-sm-3 col-xs-12'>Estado</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <select name="sltEstado" id="sltEstado" class="form-control">
                                                <?php 
                                                    foreach ($arrEstado as $estado) 
                                                    {
                                                        $repopular = set_select('sltEstado', $estado);
                                                        echo "<option value='{$estado}' {$repopular} >{$estado}</option>";
                                                    } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Status</label>
                                        <div class='col-md-6 col-sm-6 col-xs-12'>
                                            <label><input type='radio' class='flat' name='rdoStatusAluno' value='1' <?php echo set_radio('rdoStatusAluno', '1', TRUE); ?>> Ativo</label><br />
                                            <label><input type='radio' class='flat' name='rdoStatusAluno' value='0' <?php echo set_radio('rdoStatusAluno', '0'); ?>> Inativo</label>
                                        </div>	
                                    </div>
                                                    
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo base_url("aluno/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
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
    <!-- maskedinput (mascaras)-->
	<script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
    <!-- jquery ui -->
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
    <!--datapicker pt-BR (calendario traducao)-->
    <script src="<?php echo base_url('assets/js/datepicker-pt-BR.js'); ?>"></script>
    <!--regras aluno-->
    <script src="<?php echo base_url('assets/js/aluno.js'); ?>"></script>

</body>
</html>
