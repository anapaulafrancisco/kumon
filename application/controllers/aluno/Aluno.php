<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno extends CI_Controller {

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

			$this->load->model('aluno/aluno_model');
			$this->load->model('serie/serie_model');
		}
    	else
    	{
        	redirect('login');
    	}
    }
    
    //-----------------------------------------------------------

	public function index()
	{
		$arrAluno = $this->aluno_model->listarAluno();
		$arrDados = array('arrAluno' => $arrAluno);

		$this->load->view('aluno/lst_aluno_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para inserir o aluno
	 */
	public function formIncluirAluno()
	{
		$arrInfoSerie = $this->serie_model->listarSerie();
		$arrDados = array('arrInfoSerie' => $arrInfoSerie);

		$this->load->view('aluno/frm_incluir_aluno_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para editar o aluno
	 * 
	 * @param type $idAluno 
	 */
	public function formEditarAluno($idAluno)
	{
		$idAlunoDescrip = base64_decode(urldecode($idAluno));
		$arrAluno = $this->aluno_model->buscarAluno($idAlunoDescrip);
		$arrInfoSerie = $this->serie_model->listarSerie();

		$arrDados = array('arrAluno' => $arrAluno, 'arrInfoSerie' => $arrInfoSerie);
		$this->load->view('aluno/edt_aluno_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por incluir um aluno
	 */
	public function incluirAluno()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[2]');
			$this->form_validation->set_rules('txtCPF', 'CPF', 'trim|required|is_unique[aluno.cpf]');
			
			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('aluno/frm_incluir_aluno_view');
			}
			else
			{
				$nomeResponsavel = $CPFResponsavel = null;
				if(isset($arrPost['txtNomeResponsavel']) && isset($arrPost['txtCPFResponsavel']))
				{
					$nomeResponsavel = mb_strtoupper(trim($arrPost['txtNomeResponsavel']));
					$CPFResponsavel = trim($arrPost['txtCPFResponsavel']);
				}

				$arrInfoAluno = array(
					'nome_aluno' => mb_strtoupper(trim($arrPost['txtNome'])), 
					'email' => strtolower(trim($arrPost['txtEmail'])),
					'cpf' => trim($arrPost['txtCPF']),
					'data_nascimento' => implode("-", array_reverse(explode("/", $arrPost['txtDtNasc']))),
					'nome_responsavel' => $nomeResponsavel,
					'cpf_responsavel' => $CPFResponsavel,
					'sexo' => $arrPost['rdoSexo'],
					'celular' => trim($arrPost['txtCelular']),
					'telefone' => trim($arrPost['txtTelResidencial']),
					'id_serie' => $arrPost['sltSerie'],
					'cep' => trim($arrPost['txtCEP']),
					'endereco' => mb_strtoupper(trim($arrPost['txtEndereco'])),
					'bairro' => mb_strtoupper(trim($arrPost['txtBairro'])),
					'cidade' => mb_strtoupper(trim($arrPost['txtCidade'])),
					'estado' => $arrPost['sltEstado'],
					'ativo' => $arrPost['rdoStatusAluno'],
					'id_usuario_cadastro' => $this->credencial['id_usuario'],
					'data_cadastro' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->aluno_model->incluirAluno($arrInfoAluno);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao incluir aluno.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('aluno/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Aluno incluído com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('aluno/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por exibir um aluno
	 * 
	 * @param type $idAluno
	 */
	public function ver($idAluno)
	{
		$idAlunoDescrip = base64_decode(urldecode($idAluno));
		$arrAluno = $this->aluno_model->buscarAluno($idAlunoDescrip);

		$arrDados = array('arrAluno' => $arrAluno);
		$this->load->view('aluno/ver_aluno_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por editar um aluno
	 */
	public function editarAluno()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$idAlunoDescrip = base64_decode(urldecode($arrPost['hddIdAluno']));

			$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[2]');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('aluno/edt_aluno_view');
			}
			else
			{
				$nomeResponsavel = $CPFResponsavel = null;
				if(isset($arrPost['txtNomeResponsavel']) && isset($arrPost['txtCPFResponsavel']))
				{
					$nomeResponsavel = mb_strtoupper(trim($arrPost['txtNomeResponsavel']));
					$CPFResponsavel = trim($arrPost['txtCPFResponsavel']);
				}

				$arrInfoAluno = array(
					'nome_aluno' => mb_strtoupper(trim($arrPost['txtNome'])), 
					'email' => strtolower(trim($arrPost['txtEmail'])),
					'cpf' => trim($arrPost['txtCPF']),
					'data_nascimento' => implode("-", array_reverse(explode("/", $arrPost['txtDtNasc']))),
					'nome_responsavel' => $nomeResponsavel,
					'cpf_responsavel' => $CPFResponsavel,
					'sexo' => $arrPost['rdoSexo'],
					'celular' => trim($arrPost['txtCelular']),
					'telefone' => trim($arrPost['txtTelResidencial']),
					'id_serie' => $arrPost['sltSerie'],
					'cep' => trim($arrPost['txtCEP']),
					'endereco' => mb_strtoupper(trim($arrPost['txtEndereco'])),
					'bairro' => mb_strtoupper(trim($arrPost['txtBairro'])),
					'cidade' => mb_strtoupper(trim($arrPost['txtCidade'])),
					'estado' => $arrPost['sltEstado'],
					'ativo' => $arrPost['rdoStatusAluno'],
					'id_usuario_alteracao' => $this->credencial['id_usuario'],
					'data_alteracao' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->aluno_model->editarAluno($arrInfoAluno, $idAlunoDescrip);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar aluno.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('aluno/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Aluno editado com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('aluno/gerenciar');
				}	
			}
		}
	}
}