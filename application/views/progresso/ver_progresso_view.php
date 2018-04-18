<?php
    getCabecalho(); 
    $arrCredencial = get_credencial();    

    $tituloLista = '';    
    if($arrProgresso)
    {
        $nomeAluno = $arrProgresso[0]['nome_aluno'];
        $nomeCurso = $arrProgresso[0]['nome_curso'];
        $tituloLista = 'Curso: ' . $nomeCurso . ' -  Aluno: ' . $nomeAluno;
    }
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
					Progresso Estudo <small>Estágios lançados</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('progresso/gerenciar');?>"><i class="fa fa-edit"></i> Progresso Estudo</a></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $tituloLista; ?></h3>

                        <div class="pull-right box-tools">
                            <a href="<?php echo base_url("progresso/gerenciar"); ?>" class='btn btn-primary'><i class="fa fa-reply"></i> Voltar </a>
                        </div>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php echo Notificacao::getNotificacao(); ?>
                        
                        <table id="tbl-progresso" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Estágio</th>
                                    <th>Qtde Folhas</th>
                                    <th>Data Cadastro</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                    $pathExcluirProgresso = base_url("progresso/excluir/salvar"); 
                                    $idCursoCrip = urlencode(base64_encode($idCurso));
                                    $idAlunoCrip = urlencode(base64_encode($idAluno));

                                    foreach($arrProgresso as $progresso) 
									{
                                        $pathVerProgresso = base_url("progresso/ver/" .  urlencode(base64_encode($progresso['id_progresso']))); 
                                        $idProgressoCrip = urlencode(base64_encode($progresso['id_progresso']));
                                        $idModal = $progresso['id_progresso'];
                                        $dataMysql = strtotime($progresso['data_lancamento']); //usado para ordenacao correta no datatable
                                    
                                        echo "<tr>
                                                <td>{$progresso['nome_estagio']}</td>
                                                <td>{$progresso['qtde_folhas']}</td>
                                                <td data-search='{$progresso['data_lancamento']}' data-order='{$dataMysql}'>{$progresso['data_lancamento_formatada']}</td>
                                                <td>
                                                    <button type='button' class='btn btn-info btn-xs editar-pe' id='{$idModal}' name='btnEditarPE'><i class='fa fa-pencil'></i> Editar</button>     
                                                    <button type='button' class='btn btn-danger btn-xs' data-toggle='modal' data-target='.botao-excluir-progresso-{$idModal}'><i class='fa fa-trash-o'></i> Excluir</button>                             
                                                </td>
                                            </tr>";
                                    ?>   

                                            <div class='modal fade botao-excluir-progresso-<?php echo $idModal; ?>' tabindex='-1' role='dialog' aria-hidden='true' data-backdrop='static'>
                                                <div class='modal-dialog'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
                                                            <h3 class='modal-title'>Excluir</h3>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <h4>Tem certeza que deseja excluir o estágio lançado?</h4>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <form name='frmExcluirProgresso' action='<?php echo $pathExcluirProgresso; ?>' method='post'>
                                                                <input type='hidden' name='hddProgressoID' value='<?php echo $idProgressoCrip; ?>' />
                                                                <input type='hidden' name='hddCursoID' id='hddCursoID' value="<?php echo $idCursoCrip; ?>" />
	        			                                        <input type='hidden' name='hddAlunoID' id='hddAlunoID' value="<?php echo $idAlunoCrip; ?>" />
                                                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                                <button type='submit' class='btn btn-primary'>Excluir</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>		
								                  								           		
				                  	<?php
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

    <?php $pathEditarProgresso = base_url("progresso/editar/estagio_lancado"); ?>

		<div class='modal fade' id='modal-editar-pe' tabindex='-1' role='dialog' aria-hidden='true' data-backdrop='static'>
		    <div class='modal-dialog modal-sm'>
		    	<div class='modal-content'>
		        	<div class='modal-header'>
		              	<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
		              	<h3 class='modal-title'>Editar</h3>
		        	</div>
		        	<form name='frmEditarProgresso' id='frmEditarProgresso' action='<?php echo $pathEditarProgresso; ?>' method='post'>
		            <div class='modal-body'>
		        		 <div class="row">
                            <div class='col-md-8'>
                                <label for="txtQtdeFolha" class="control-label">Estágio *</label>
                                <select name="sltEstagio" id="sltEstagio" class="form-control">
                                    <option value="">Selecione o estágio</option>
                                    <?php
                                        foreach ($arrInfoEstagio as $estagio)
                                        {
                                            //$estagioSelecionado = $arrMatricula['id_estagio'] == $estagio['id_estagio'] ? "selected='selected'" : ''; 
                                            echo "<option value='{$estagio['id_estagio']}'>{$estagio['nome_estagio']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
							<div class="col-md-8">
						  		<label for="txtQtdeFolha" class="control-label">Qtde folhas *</label>
								<input type="number" id="txtQtdeFolha" name="txtQtdeFolha" class="form-control <?php echo (form_error('txtQtdeFolha') ? 'erro_formulario' : ''); ?>" value="<?php echo set_value('txtQtdeFolha'); ?>" required>
                                <?php echo form_error('txtQtdeFolha'); ?>
						  	</div>
						</div>
															                        
		            </div>
		        	<div class='modal-footer'>
	        			<input type='hidden' name='hddProgressoIDEditar' id='hddProgressoIDEditar' />
	        			<input type='hidden' name='hddCursoID' id='hddCursoID' value="<?php echo $idCursoCrip; ?>" />
	        			<input type='hidden' name='hddAlunoID' id='hddAlunoID' value="<?php echo $idAlunoCrip; ?>" />
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
            $('#tbl-progresso').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json'
                },
                order: [[ 2, "desc" ]]
            });

            //abre popup com as info do progresso estudo aluno para edicao
		  	$(document).on("click", ".editar-pe", function() {
				var idProgresso = $(this).attr("id");
				 
				$.ajax({
					url: "<?php echo base_url() ?>ajax/ProgressoAjax/buscaInfoProgressoEstudo",
					type: 'POST',
					data: {idProgresso: idProgresso},
					dataType: 'json',
					success: function(infoPE)
					{
             			$('#modal-editar-pe').modal('show');
						$('#sltEstagio').val(infoPE.id_estagio);
						$('#txtQtdeFolha').val(infoPE.qtde_folhas);
						$('#hddProgressoIDEditar').val(idProgresso);
					}
				})			
            });
            
            //VALIDACAO FORMULARIO
            $('#frmEditarProgresso').validate({
                rules: {
                    sltEstagio: {
                        required: true
                    },
                    txtQtdeFolha: {
                        required: true
                    }	  
                },
                messages: {
                    sltEstagio: {
                        required: "O campo Estágio é obrigatório."
                    },
                    txtQtdeFolha: {
                        required: "O campo Qtde folhas é obrigatório."
                    }
                }
            });
        })
    </script>
</body>
</html>
