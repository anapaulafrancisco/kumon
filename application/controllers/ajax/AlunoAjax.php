<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AlunoAjax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('aluno/aluno_model');
	}
	
	/**
	 * Funcao responsavel por buscar os alunos matriculados no curso
	 *
	 * @return void
	 */
	function buscaAluno()
	{
		$idCurso = $this->input->post('idCurso');
		$arrInfoAluno = $this->aluno_model->buscaAlunoCurso($idCurso);

		$optionAluno = "<option value=''>Nenhum aluno encontrado</option>";

		if($arrInfoAluno)
		{
			$optionAluno = "<option value=''>Selecione um aluno</option>";
			foreach ($arrInfoAluno as $aluno)
			{
				$optionAluno .= "<option value='{$aluno['id_aluno']}'>{$aluno['nome_aluno']}</option>".PHP_EOL;
			}
		}
		
		echo $optionAluno;
	}
}