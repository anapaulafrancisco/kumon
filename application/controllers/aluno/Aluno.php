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
    
}   