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

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por enviar uma nova senha
	 *
	 */
	/* public function esqueciSenha()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			$email = trim($arrPost['txtEmailEsqSenha']);

			if(strlen($email) > 0)
			{
				$arrUsuarioEncontrado = $this->login_model->buscaUsuario($email);

				if($arrUsuarioEncontrado)
				{
					//gera a nova senha
					$novaSenha = substr(str_shuffle(str_replace(array('.', '@'), '', $email)), 0, 4) . mt_rand(11, 99);
					
					//atualiza senha do usuario
					$arrInfoUsuario = array(
						'senha' => md5(trim(SALT_SENHA . $novaSenha)),
						'data_alteracao' => date('Y-m-d H:i:s'),
						'id_usuario_alteracao' => $arrUsuarioEncontrado['id_usuario']
					);

					$this->login_model->atualizarSenha($arrInfoUsuario, $arrUsuarioEncontrado['id_usuario']);
					$a = $this->montaEmailNovaSenha($arrUsuarioEncontrado['nome'], $arrUsuarioEncontrado['email'], $novaSenha);
					//echo $a;
					//enviar email - ver como faço envio de email no localhost
					Notificacao::setNotificacao("Uma nova senha foi gerada e enviada para o Email: {$arrUsuarioEncontrado['email']}", Notificacao::$NOTIFICACAO_SUCESSO);
					redirect('login');
				}
				else
				{
					Notificacao::setNotificacao('Usuário não localizado.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('login');
				}
			}
		}
	} */

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por montar o conteudo do email - nova senha usuario
	 *
	 * @param [varchar] $nome
	 * @param [int] $dias
	 * @param [varchar] $passaporte
	 * @param [date] $dataVenc
	 * @return void
	 */
	/* public function montaEmailNovaSenha($usuarioNome, $email, $novaSenha)
	{
		$textoEmail = "Você esqueceu a senha, não tem problema! Para acessar o SAAR informe os dados abaixo.<br />";
		$textoEmail .= "Não se esqueça de trocar a senha após o login.<br />";
        $informacoes = "<strong>Email: </strong> {$email} <br />
						<strong>Senha: </strong> {$novaSenha} <br />";
						
        $arrDados = array(
            'nomeDestinatario' 	=> $usuarioNome,
            'textoEmail' 		=> $textoEmail,
            'informacoes' 		=> $informacoes
		);
		
		return $this->load->view('comunicado/template_alerta_view',$arrDados,TRUE);	
	} */

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por enviar email
	 *
	 * @param [varchar] $destinatario
	 * @param [varchar] $assunto
	 * @param [varchar] $conteudo
	 * @return void
	 */
	/* public function enviarEmail($emailDestinatario, $assunto, $conteudo)
	{
		$this->email->from('comunicado@saarrugby.com.br', 'SAAR');
		$this->email->to($emailDestinatario);
		$this->email->subject($assunto);
		$this->email->message($conteudo);
		$this->email->send();		 
	} */
}
