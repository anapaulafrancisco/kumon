<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public $credencial;

	public function __construct()
	{
		parent::__construct();
		
		if (is_logado())
	    {
			$this->credencial = get_credencial();

			$this->load->model('aluno/aluno_model');
		}
    	else
    	{
        	redirect('login');
    	}
	}
	
	public function index()
	{
		$arrAluno = $this->aluno_model->listarAluno(1);
		$qtdeAluno = count($arrAluno);

		$arrDados = array('qtdeAluno' => $qtdeAluno);
		$this->load->view('home_view', $arrDados);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */

