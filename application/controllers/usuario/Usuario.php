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
	        // $this->load->model('academia/academia_model');
	        // $this->load->model('perfil/perfil_model');
		}
    	else
    	{
        	redirect('login');
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
}