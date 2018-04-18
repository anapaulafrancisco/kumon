<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progresso extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (is_logado())
	    {
	        $this->credencial = get_credencial();

	        //$arrPerfilNome = explode(',', $this->credencial['perfis_nomes']);
	        
	        // if(!in_array('admin', $arrPerfilNome))
	        // {
	        // 	redirect('login');
	        // }

			$this->load->model('progresso/progresso_model');
			$this->load->model('curso/curso_model');
			$this->load->model('matricula/matricula_model');
			$this->load->model('estagio/estagio_model');
		}
    	else
    	{
        	redirect('login');
    	}
    }
    
    //-----------------------------------------------------------

	public function index()
	{
		$arrMatricula = $this->matricula_model->listarMatricula(1);
		$arrDados = array('arrMatricula' => $arrMatricula);

		$this->load->view('progresso/lst_progresso_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para inserir o progresso
	 */
	public function formIncluirProgresso()
	{
		$arrCurso = $this->curso_model->listarCursos(1);
		$arrDados = array('arrCurso' => $arrCurso);
	
		$this->load->view('progresso/frm_incluir_progresso_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para editar a pessoa
	 * 
	 * @param type $idPessoa 
	 */
	public function formEditarPessoa($idPessoa)
	{
		$idPessoaDescrip = base64_decode(urldecode($idPessoa));
		$arrProgresso = $this->progresso_model->buscarPessoa($idPessoaDescrip);

		$arrDados = array('arrProgresso' => $arrProgresso);
		$this->load->view('progresso/edt_progresso_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por incluir um progresso estudo
	 */
	public function incluirProgresso()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$this->form_validation->set_rules('sltCurso', 'Curso', 'required');
			$this->form_validation->set_rules('sltAluno', 'Aluno', 'required');
			$this->form_validation->set_rules('sltEstagio', 'Estágio', 'required');
			$this->form_validation->set_rules('txtQtdeFolha', 'Qtde folhas', 'required|integer');
			$this->form_validation->set_rules('txtDataLancamento', 'Data', 'required');
			
			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->formIncluirProgresso();
			}
			else
			{
				$dtProgressoEstudo = implode("-", array_reverse(explode("/", $arrPost['txtDataLancamento'])));
				$dtProgressoEstudoVerificar = substr($dtProgressoEstudo, 0, 7);
				
				$arrProgressoEstudo = $this->progresso_model->verificaProgressoEstudo($arrPost['sltCurso'], $arrPost['sltAluno'], $dtProgressoEstudoVerificar);

				if($arrProgressoEstudo)
				{
					Notificacao::setNotificacao("Estágio já foi lançado para este aluno, neste curso e neste mês! (Curso: {$arrProgressoEstudo['nome_curso']}, Aluno: {$arrProgressoEstudo['nome_aluno']}, Lançado por: {$arrProgressoEstudo['nome_usuario']}, Data: {$arrProgressoEstudo['data_lancamento_formatada']}).", Notificacao::$NOTIFICACAO_ERRO);
					redirect('progresso/gerenciar');
				}

				$arrInfoProgresso = array(
					'id_aluno' => $arrPost['sltAluno'], 
					'id_estagio' => $arrPost['sltEstagio'],
					'qtde_folhas' => trim($arrPost['txtQtdeFolha']),
					'data_lancamento' => implode("-", array_reverse(explode("/", $arrPost['txtDataLancamento']))),
					'id_usuario_cadastro' => $this->credencial['id_usuario'],
					'data_cadastro' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->progresso_model->incluirProgresso($arrInfoProgresso);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao lançar estágio.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('progresso/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Estágio lançado com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('progresso/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por exibir a lista de progresso estudo do aluno
	 * 
	 * @param type $idProgresso
	 */
	public function ver($idCurso, $idAluno)
	{
		$idCursoDescrip = base64_decode(urldecode($idCurso));
		$idAlunoDescrip = base64_decode(urldecode($idAluno));

		$arrInfoEstagio = $this->estagio_model->buscaEstagioCurso($idCursoDescrip);
		$arrProgresso = $this->progresso_model->buscaProgressoAluno($idCursoDescrip, $idAlunoDescrip);
		$arrDados = array(
			'arrProgresso' => $arrProgresso, 
			'arrInfoEstagio' => $arrInfoEstagio, 
			'idCurso' => $idCursoDescrip, 
			'idAluno' => $idAlunoDescrip
		);

		$this->load->view('progresso/ver_progresso_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por editar um progresso estudo
	 */
	public function editarProgresso()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$this->form_validation->set_rules('sltEstagio', 'Estágio', 'required');
			$this->form_validation->set_rules('txtQtdeFolha', 'Qtde folhas', 'required|integer');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->ver($arrPost['hddCursoID'], $arrPost['hddAlunoID']);
			}
			else
			{
				$arrInfoProgresso = array(
					'id_estagio' => $arrPost['sltEstagio'],
					'qtde_folhas' => trim($arrPost['txtQtdeFolha']),
					'id_usuario_alteracao' => $this->credencial['id_usuario'],
					'data_alteracao' => date('Y-m-d H:i:s')
				);
		
				$this->db->trans_begin();

				$this->progresso_model->editarProgresso($arrInfoProgresso, $arrPost['hddProgressoIDEditar']);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar estágio.', Notificacao::$NOTIFICACAO_ERRO);
					$this->ver($arrPost['hddCursoID'], $arrPost['hddAlunoID']);
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Estágio editado com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    $this->ver($arrPost['hddCursoID'], $arrPost['hddAlunoID']);
				}	
			}
		}
	}
	
	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por excluir um progresso estudo
	 * 
	 * @return [type] [description]
	 */
	public function excluirProgresso()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			$idProgressoDescrip = base64_decode(urldecode($arrPost['hddProgressoID']));

			$this->db->trans_begin();

			$this->progresso_model->excluirProgressoEstudo($idProgressoDescrip);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				Notificacao::setNotificacao('Erro ao excluir estágio.', Notificacao::$NOTIFICACAO_ERRO);
				$this->ver($arrPost['hddCursoID'], $arrPost['hddAlunoID']);
			}
			else
			{
			    $this->db->trans_commit();
			    Notificacao::setNotificacao('Estágio excluído com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
			    $this->ver($arrPost['hddCursoID'], $arrPost['hddAlunoID']);
			}				
		}
	}
}   