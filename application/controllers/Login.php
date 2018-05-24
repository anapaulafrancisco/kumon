<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
	}

	//-----------------------------------------------------------
	
	public function index()
	{
		$this->load->view('login_view');
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por autenticar o usuario no sistema
	 */
	public function autenticar()
	{
		$usuario = trim($this->input->post('txtUsuario', TRUE));
		$senha = md5(trim(SALT_SENHA . $this->input->post('txtSenha', TRUE)));

		$arrUsuarioEncontrado = $this->login_model->buscaUsuario($usuario);

		if($arrUsuarioEncontrado)
		{
			if($arrUsuarioEncontrado['senha'] == $senha)
			{
				$this->session->set_userdata(array('credencial' => $arrUsuarioEncontrado));
				redirect('home');
			}
			else
			{
				Notificacao::setNotificacao('Senha incorreta.', Notificacao::$NOTIFICACAO_ERRO);
			 	redirect('login');
			}
		}
		else
		{
			Notificacao::setNotificacao('Usuário não localizado.', Notificacao::$NOTIFICACAO_ERRO);
		 	redirect('login');
		}

	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por destruir a sessao do usuario logado
	 * 
	 */
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
