<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioAjax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('aluno/aluno_model');
		$this->load->model('pessoa/pessoa_model');
		$this->load->model('matricula/matricula_model');
	}
	
	/**
	 * Funcao responsavel por buscar os usuarios do sistema
	 *
	 * @return void
	 */
	function buscaUsuarioSistema()
	{
		$idTipoUsuario = $this->input->post('idTipoUsuario');

		if($idTipoUsuario == 3) //auxiliar
		{
			$tipoPessoa = 'auxiliar';
			$arrInfoPessoa = $this->pessoa_model->listarPessoaPorTipo($tipoPessoa);

			$optionUsuario = "<option value=''>Nenhum usuário encontrado</option>";

			if($arrInfoPessoa)
			{
				$optionUsuario = "<option value=''>Selecione</option>";
				foreach ($arrInfoPessoa as $pessoa)
				{
					$optionUsuario .= "<option value='{$pessoa['id_pessoa']}'>{$pessoa['nome_pessoa']}</option>".PHP_EOL;
				}
			}
		}
		else //aluno
		{
			$arrInfoAluno = $this->matricula_model->buscaAlunosMatriculados(1);

			$optionUsuario = "<option value=''>Nenhum usuário encontrado</option>";
			
			if($arrInfoAluno)
			{
				$optionUsuario = "<option value=''>Selecione</option>";
				foreach ($arrInfoAluno as $aluno)
				{
					$optionUsuario .= "<option value='{$aluno['id_aluno']}'>{$aluno['nome_aluno']}</option>".PHP_EOL;
				}
			}
		}

		echo $optionUsuario;
	}

	/**
	 * Funcao responsavel por buscar o email do usuario do sistema
	 *
	 * @return void
	 */
	function buscaEmailUsuarioSistema()
	{
		$idTipoUsuario = $this->input->post('idTipoUsuario');
		$idUsuarioSistema = $this->input->post('idUsuarioSistema');

		if($idTipoUsuario == 3) //auxiliar
		{
			$tipoPessoa = 'auxiliar';
			$arrInfoPessoa = $this->pessoa_model->buscarPessoa($idUsuarioSistema);

			echo json_encode($arrInfoPessoa);
		}
		else //aluno
		{
			$arrInfoAluno = $this->aluno_model->buscarAluno($idUsuarioSistema);

			echo json_encode($arrInfoAluno);
		}
	}
}