<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa extends CI_Controller {

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

	        $this->load->model('pessoa/pessoa_model');
		}
    	else
    	{
        	redirect('login');
    	}
    }
    
    //-----------------------------------------------------------

	public function index()
	{
		$arrPessoa = $this->pessoa_model->listarPessoa();
		$arrDados = array('arrPessoa' => $arrPessoa);

		$this->load->view('pessoa/lst_pessoa_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para inserir a pessoa
	 */
	public function formIncluirPessoa()
	{
		$this->load->view('pessoa/frm_incluir_pessoa_view');
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
		$arrPessoa = $this->pessoa_model->buscarPessoa($idPessoaDescrip);

		$arrDados = array('arrPessoa' => $arrPessoa);
		$this->load->view('pessoa/edt_pessoa_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por incluir uma pessoa
	 */
	public function incluirPessoa()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[2]');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('pessoa/frm_incluir_pessoa_view');
			}
			else
			{
				$arrInfoPessoa = array(
					'nome_pessoa' => mb_strtoupper(trim($arrPost['txtNome'])), 
					'email' => strtolower(trim($arrPost['txtEmail'])),
					'celular' => trim($arrPost['txtCelular']),
					'telefone' => trim($arrPost['txtTelResidencial']),
					'tipo' => $arrPost['sltTipo'],
					'ativo' => $arrPost['rdoStatusPessoa'],
					'id_usuario_cadastro' => $this->credencial['id_usuario'],
					'data_cadastro' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->pessoa_model->incluirPessoa($arrInfoPessoa);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao incluir pessoa.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('pessoa/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Pessoa incluída com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('pessoa/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por exibir uma pessoa
	 * 
	 * @param type $idPessoa
	 */
	public function ver($idPessoa)
	{
		$idPessoaDescrip = base64_decode(urldecode($idPessoa));
		$arrPessoa = $this->pessoa_model->buscarPessoa($idPessoaDescrip);

		$arrDados = array('arrPessoa' => $arrPessoa);
		$this->load->view('pessoa/ver_pessoa_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por editar uma pessoa
	 */
	public function editarPessoa()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$idPessoaDescrip = base64_decode(urldecode($arrPost['hddIdPessoa']));

			$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[2]');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('pessoa/edt_pessoa_view');
			}
			else
			{
				$arrInfoPessoa = array(
					'nome_pessoa' => mb_strtoupper(trim($arrPost['txtNome'])), 
					'email' => strtolower(trim($arrPost['txtEmail'])),
					'celular' => trim($arrPost['txtCelular']),
					'telefone' => trim($arrPost['txtTelResidencial']),
					'tipo' => $arrPost['sltTipo'],
					'ativo' => $arrPost['rdoStatusPessoa'],
					'id_usuario_alteracao' => $this->credencial['id_usuario'],
					'data_alteracao' => date('Y-m-d H:i:s')
				);
		
				$this->db->trans_begin();

				$this->pessoa_model->editarPessoa($arrInfoPessoa, $idPessoaDescrip);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar pessoa.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('pessoa/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Pessoa editada com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('pessoa/gerenciar');
				}	
			}
		}
	}
}   