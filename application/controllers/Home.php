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
		}
    	else
    	{
        	redirect('login');
    	}
	}
	
	public function index()
	{
		$this->load->view('home_view');
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */

