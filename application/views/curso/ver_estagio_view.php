<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();

    $tituloLista = '';
    if ($arrEstagioCurso)
    {
        $nomeCurso = $arrEstagioCurso[0]['nome_curso'];
        $tituloLista = 'Estágios do Curso - ' . $nomeCurso;
    }

    $idCursoCrip = urlencode(base64_encode($idCurso));
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
					Cursos <small>Estágios lançados</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('curso/gerenciar');?>"><i class="fa fa-folder-open"></i> Curso</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $tituloLista; ?></h3>

                        <div class="pull-right box-tools">
                            <a href="<?php echo base_url("curso/gerenciar"); ?>" class='btn btn-primary btn-sm'><i class="fa fa-reply"></i> Voltar </a>
                            <a href='<?php echo base_url("curso/estagio/incluir/") . $idCursoCrip ?>' class='btn btn-success btn-sm'><i class="fa fa-plus"></i> Incluir </a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php echo Notificacao::getNotificacao(); ?>
                        
                        <table id="tbl-estagio" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Estágio</th>
                                    <th>Qtde bloco</th>
                                    <th>Qtde folha</th>
                                    <th>Numeração bloco</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    

                                    foreach($arrEstagioCurso as $estagio) 
									{
                                        $idModal = $estagio['id_estagio'];
                                        $status = $estagio['ativo'] ? 'Ativo' : 'Inativo';
                                    
                                        echo "<tr>
                                                <td>{$estagio['nome_estagio']}</td>
                                                <td>{$estagio['qtde_bloco']}</td>
                                                <td>{$estagio['qtde_folha']}</td>
                                                <td>{$estagio['numeracao_bloco']}</td>
                                                <td>{$status}</td>
                                                <td>
                                                    <button type='button' class='btn btn-info btn-xs editar-est' id='{$idModal}' name='btnEditarEST'><i class='fa fa-pencil'></i> Editar</button>     
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

    <?php $pathEditarEstagio = base_url("curso/estagio/editar"); ?>

		<div class='modal fade' id='modal-editar-est' tabindex='-1' role='dialog' aria-hidden='true' data-backdrop='static'>
		    <div class='modal-dialog modal-sm'>
		    	<div class='modal-content'>
		        	<div class='modal-header'>
		              	<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
		              	<h3 class='modal-title'>Editar</h3>
		        	</div>
		        	<form name='frmEditarEstagio' id='frmEditarEstagio' action='<?php echo $pathEditarEstagio; ?>' method='post'>
                        <div class='modal-body'>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="txtNomeEstagio" class="control-label">Nome estágio *</label>
                                    <input type="text" id="txtNomeEstagio" name="txtNomeEstagio" class="form-control <?php echo (form_error('txtNomeEstagio') ? 'erro_formulario' : ''); ?>" required>
                                    <?php echo form_error('txtNomeEstagio'); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="txtQtdeBloco" class="control-label">Qtde bloco *</label>
                                    <input type="number" id="txtQtdeBloco" name="txtQtdeBloco" class="form-control <?php echo (form_error('txtQtdeBloco') ? 'erro_formulario' : ''); ?>" required>
                                    <?php echo form_error('txtQtdeBloco'); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="txtQtdeFolha" class="control-label">Qtde folha *</label>
                                    <input type="number" id="txtQtdeFolha" name="txtQtdeFolha" class="form-control <?php echo (form_error('txtQtdeFolha') ? 'erro_formulario' : ''); ?>" required>
                                    <?php echo form_error('txtQtdeFolha'); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="txtNumeracaoBloco" class="control-label">Numeração bloco *</label>
                                    <input type="number" id="txtNumeracaoBloco" name="txtNumeracaoBloco" class="form-control <?php echo (form_error('txtNumeracaoBloco') ? 'erro_formulario' : ''); ?>" required>
                                    <?php echo form_error('txtNumeracaoBloco'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <label for="txtNumeracaoBloco" class="control-label">Status</label><br />
                                    <input type='radio' class='flat' name='rdoStatusEstagio' value='1' id="rdoStatusEstagioAtivo"> Ativo
                                    <input type='radio' class='flat' name='rdoStatusEstagio' value='0' id="rdoStatusEstagioInativo"> Inativo
                                </div>
                            </div>
                                                                                        
                        </div>
                        <div class='modal-footer'>
                            <input type='hidden' name='hddEstagioIDEditar' id='hddEstagioIDEditar' />
                            <input type='hidden' name='hddCursoID' id='hddCursoID' value="<?php echo $idCursoCrip; ?>" />
                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                            <button type='submit' class='btn btn-primary'>Editar</button>
                        </div>
		            </form>
		      	</div>
		    </div>
		</div>

    <!-- DataTables -->
    <script src="<?php echo base_url('template_admin/bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('template_admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script> 
    <script src="<?php echo base_url('template_admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <!--jquery.validate (validacao formulario)-->
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
    
    <script>
        $(function () {
            $('#tbl-estagio').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json'
                },
                order: [[ 0, "asc" ]]
            });

            //abre popup com as info do progresso estudo aluno para edicao
		  	$(document).on("click", ".editar-est", function() {
				var idEstagio = $(this).attr("id");
				 
				$.ajax({
					url: "<?php echo base_url() ?>ajax/EstagioAjax/buscaInfoEstagio",
					type: 'POST',
					data: {idEstagio: idEstagio},
					dataType: 'json',
					success: function(infoEstagio)
					{
                        $('#modal-editar-est').modal('show');
                       
                        var statusEstagio = parseInt(infoEstagio.ativo);
                        console.log(typeof(statusEstagio == 1));
                        if(statusEstagio == 1){
                            $('#rdoStatusEstagioAtivo').attr('checked', true);
                            $('#rdoStatusEstagioInativo').attr('checked');
                        }
                        else{
                            $('#rdoStatusEstagioInativo').attr('checked', true);
                            $('#rdoStatusEstagioAtivo').attr('checked');
                        }

                    	$('#txtNomeEstagio').val(infoEstagio.nome_estagio);
						$('#txtQtdeBloco').val(infoEstagio.qtde_bloco);
						$('#txtQtdeFolha').val(infoEstagio.qtde_folha);
						$('#txtNumeracaoBloco').val(infoEstagio.numeracao_bloco);
						$('#hddEstagioIDEditar').val(idEstagio);
					}
				})			
            });
            
            //VALIDACAO FORMULARIO
            $('#frmEditarEstagio').validate({
                rules: {
                    txtNomeEstagio: {
                        required: true
                    },
                    txtQtdeBloco: {
                        required: true
                    },	  
                    txtQtdeFolha: {
                        required: true
                    },	  
                    txtNumeracaoBloco: {
                        required: true
                    },
                    rdoStatusEstagio: {
                        required: true
                    }	  
                },
                messages: {
                    txtNomeEstagio: {
                        required: "O campo Nome estágio é obrigatório."
                    },
                    txtQtdeBloco: {
                        required: "O campo Qtde bloco é obrigatório."
                    },
                    txtQtdeFolha: {
                        required: "O campo Qtde folha é obrigatório."
                    },
                    txtNumeracaoBloco: {
                        required: "O campo Númeração bloco é obrigatório."
                    },
                    rdoStatusEstagio: {
                        required: "O campo Status é obrigatório."
                    }
                }
            });
        })
    </script>
</body>
</html>
