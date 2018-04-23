<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AlunoAjax extends CI_Controller {

	public $credencial;

	public function __construct()
	{
		parent::__construct();

		$this->credencial = get_credencial();

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

		//se for aluno
		if($this->credencial['perfis_nomes'] == 'aluno')
		{
			//busca aluno ID pelo email do usuario logado
			$arrIdAluno = $this->aluno_model->buscaIDAlunoPorEmail($this->credencial['email']);
	
			//busca os cursos do aluno
			$arrAluno = $this->aluno_model->buscarAluno($arrIdAluno['id_aluno']);

			$optionAluno = "<option value='{$arrAluno['id_aluno']}'>{$arrAluno['nome_aluno']}</option>";
		}
		else
		{
			if($arrInfoAluno)
			{
				$optionAluno = "<option value=''>Selecione um aluno</option>";
				foreach ($arrInfoAluno as $aluno)
				{
					$optionAluno .= "<option value='{$aluno['id_aluno']}'>{$aluno['nome_aluno']}</option>".PHP_EOL;
				}
			}	
		}
		
		echo $optionAluno;
	}
}