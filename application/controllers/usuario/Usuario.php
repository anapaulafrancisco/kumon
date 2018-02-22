<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (is_logado())
	    {
	        $this->credencial = get_credencial();
	        
			$this->load->model('usuario/usuario_model');
			$this->load->model('perfil/perfil_model');
		}
    	else
    	{
        	redirect('login');
    	}
	}

	public function index()
	{
		$arrUsuario = $this->usuario_model->listarUsuario($this->credencial['id_usuario']);
		$arrDados = array('arrUsuario' => $arrUsuario);

		$this->load->view('usuario/lst_usuario_view', $arrDados);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para inserir o usuario
	 */
	public function formIncluirUsuario()
	{
		$arrPerfil = $this->usuario_model->listarPerfil(1);

		$arrDados = array('arrPerfil' => $arrPerfil);

		$this->load->view('usuario/frm_incluir_usuario_view', $arrDados);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por incluir um usuario
	 */
	public function incluirUsuario()
	{	
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();

			$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[2]');
			$this->form_validation->set_rules('txtEmail', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('txtUsuario', 'Usuário', 'trim|required|is_unique[usuario.usuario]');
			$this->form_validation->set_rules('pwdSenha', 'Senha', 'trim|required|callback_verifica_senha');
			$this->form_validation->set_rules('rdoPerfil', 'Perfil', 'required');
			
			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C; font-weight: bold;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->formIncluirUsuario();
			}
			else
			{
				$this->db->trans_begin();

				$arrInfoUsuario = array(
					'nome_usuario' => mb_strtoupper(trim($arrPost['txtNome'])),
					'email' => strtolower(trim($arrPost['txtEmail'])),
					'usuario' => trim($arrPost['txtUsuario']),
					'senha' => md5(trim(SALT_SENHA . $arrPost['pwdSenha'])),
					'ativo' => $arrPost['rdoStatusUsuario'],
					'data_cadastro' => date('Y-m-d H:i:s'),
					'id_usuario_cadastro' => $this->credencial['id_usuario']
				);

				$idUsuario = $this->usuario_model->incluirUsuario($arrInfoUsuario);

				$arrInfoPerfil = array(
					'id_usuario' => $idUsuario,
					'id_perfil' => $arrPost['rdoPerfil']
				);

				$this->perfil_model->incluirPerfil($arrInfoPerfil);
			
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao incluir usuário.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('usuario/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Usuário incluído com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('usuario/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por exibir um usuario
	 * 
	 * @param type $idUsuario 
	 */
	public function ver($idUsuario)
	{
		$idUsuarioDescrip = base64_decode(urldecode($idUsuario));
		$arrUsuario = $this->usuario_model->buscarUsuario($idUsuarioDescrip);

		$arrDados = array('arrUsuario' => $arrUsuario);
		$this->load->view('usuario/ver_usuario_view', $arrDados);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para editar o usuario
	 * 
	 * @param type $idUsuario 
	 */
	public function formEditarUsuario($idUsuario)
	{
		$arrPerfil = $this->usuario_model->listarPerfil(1);

		$idUsuarioDescrip = base64_decode(urldecode($idUsuario));
		$arrUsuario = $this->usuario_model->buscarUsuario($idUsuarioDescrip);

		$arrDados = array('arrUsuario' => $arrUsuario, 'arrPerfil' => $arrPerfil);
		
		$this->load->view('usuario/edt_usuario_view', $arrDados);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por editar um usuario
	 */
	public function editarUsuario()
	{	
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();

			$idUsuarioDescrip = base64_decode(urldecode($arrPost['hddIdUsuario']));

			$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[2]');
			$this->form_validation->set_rules('txtEmail', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('txtUsuario', 'Usuário', 'trim|required');
			$this->form_validation->set_rules('rdoPerfil', 'Perfil', 'required');
		
			if(!empty($arrPost['pwdSenha']))
			{
				$this->form_validation->set_rules('pwdSenha', 'Senha', 'trim|callback_verifica_senha');
			}
			
			$this->form_validation->set_rules('chkPerfil[]', 'Perfil', 'required');
			
			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C; font-weight: bold;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->formEditarUsuario($arrPost['hddIdUsuario']);
			}
			else
			{
				$this->db->trans_begin();	

				$arrInfoUsuario = array(
					'nome_usuario' => mb_strtoupper(trim($arrPost['txtNome'])),
					'email' => strtolower(trim($arrPost['txtEmail'])),
					'usuario' => trim($arrPost['txtUsuario']),
					'ativo' => $arrPost['rdoStatusUsuario'],
					'data_alteracao' => date('Y-m-d H:i:s'),
					'id_usuario_alteracao' => $this->credencial['id_usuario']
				);

				if(!empty($arrPost['pwdSenha']))
				{
					$arrInfoUsuario['senha'] = md5(trim(SALT_SENHA . $arrPost['pwdSenha']));
				}

				$this->usuario_model->editarUsuario($arrInfoUsuario, $idUsuarioDescrip);

				//excluir todos os perfis para inserir novamente
				$this->perfil_model->excluirPerfil($idUsuarioDescrip);

				$arrInfoPerfil = array(
					'id_usuario' => $idUsuarioDescrip,
					'id_perfil' => $arrPost['rdoPerfil']
				);

				$this->perfil_model->incluirPerfil($arrInfoPerfil);
	
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar usuário.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('usuario/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Usuário editado com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('usuario/gerenciar');
				}	
			}
		}
	}

    //-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por chamar o form para alteracao de algumas configuracoes
	 * 
	 * @return [type] [description]
	 */
	public function config()
	{
		$arrUsuario = $this->usuario_model->buscarUsuario($this->credencial['id_usuario']);

		$arrDados = array('arrUsuario' => $arrUsuario);
		$this->load->view('usuario/config_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por validar a senha
	 * 
	 * @param type $senha 
	 * @return boolean
	 */
	public function verifica_senha($senha)
	{
		if(strlen($senha) < 5)
		{
			$this->form_validation->set_message('verifica_senha', 'Senha fora do padrão. Letras e números são obrigatórios. Mínimo 5 caracteres.');
			return FALSE;
		}
		else if(preg_match_all('/([a-z]{1,})|([0-9]{1,})/', $senha) < 2)
		{
		    $this->form_validation->set_message('verifica_senha', 'Senha fora do padrão. Letras e números são obrigatórios.');
			return FALSE;
		}
		else
		{
		    return TRUE;
		}
	}
}