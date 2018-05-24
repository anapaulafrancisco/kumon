<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EstagioAjax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('estagio/estagio_model');
	}
	
	/**
	 * Funcao responsavel por buscar os estagios do curso
	 *
	 * @return void
	 */
	function buscaEstagio()
	{
		$idCurso = $this->input->post('idCurso');
		$arrInfoEstagio = $this->estagio_model->buscaEstagioCurso($idCurso);

		$optionEstagio = "<option value=''>Nenhum estágio encontrado</option>";

		if($arrInfoEstagio)
		{
			$optionEstagio = "<option value=''>Selecione</option>";
			foreach ($arrInfoEstagio as $estagio)
			{
				$optionEstagio .= "<option value='{$estagio['id_estagio']}'>{$estagio['nome_estagio']}</option>".PHP_EOL;
			}
		}
		
		echo $optionEstagio;
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar informacoes do estagio
	 *
	 * @return void
	 */
	function buscaInfoEstagio()
	{
		$idEstagio = $this->input->post('idEstagio');

		$arrInfoEstagio = $this->estagio_model->buscaInfoEstagioCurso($idEstagio);

		echo json_encode($arrInfoEstagio);
	}
}