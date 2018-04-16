<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProgressoAjax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('progresso/progresso_model');
    }
 
    /**
	 * Funcao responsavel por buscar o progresso estudo lancado do aluno
	 *
	 * @return void
	 */
	function buscaInfoProgressoEstudo()
	{
        $idProgresso = $this->input->post('idProgresso');
		
		$arrInfoProgressoAluno = $this->progresso_model->buscaInfoProgressoEstudoAluno($idProgresso);
	
		echo json_encode($arrInfoProgressoAluno); 		
    }
    
}