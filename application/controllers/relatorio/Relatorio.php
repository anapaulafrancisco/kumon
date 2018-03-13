<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public $credencial;

	public function __construct()
	{
        parent::__construct();

        if (is_logado())
	    {
			$this->credencial = get_credencial();
			
			$this->load->model('relatorio/relatorio_model');
			$this->load->model('curso/curso_model');
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
		if($this->session->has_userdata('post_filtro'))
		{
			$this->session->unset_userdata('post_filtro');
		}

        $arrCurso = $this->curso_model->listarCursos();
		
		$arrDados = array(
			'arrCurso' => $arrCurso, 
		);

		$arrDados['arrInfoRelFolhaMes'] = array();
		$arrDados['arrInfoAluno'] = array();
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();

			if(isset($arrPost['btnLimparFiltro']))
			{
				$this->session->unset_userdata('post_filtro');
			}
			else
			{
				$this->session->set_userdata(array('post_filtro' => $arrPost));	
	
				$arrInfoAluno = $this->aluno_model->buscaAlunoCurso($arrPost['sltCurso']);
				$periodo = date('Y-m-01', strtotime("-{$arrPost['sltPeriodo']} month"));
	
				$arrInfoRelFolhaMes = $this->relatorio_model->relFolhaMes($arrPost['sltCurso'], $arrPost['sltAluno'], $periodo);
	
				$arrDados['arrInfoRelFolhaMes'] = $arrInfoRelFolhaMes;
				$arrDados['arrInfoAluno'] = $arrInfoAluno;
			}
		}
		
		$this->load->view('relatorio/lst_relatorio_view', $arrDados);
	}

    //-----------------------------------------------------------

	/**
	 * Funcao responsavel por exibir o relatorio
	 * 
	 * @param type $idRelatorio 
	 */
	public function ver($idRelatorio)
	{
		$idRelatorioDescrip = base64_decode(urldecode($idRelatorio));
		$arrRelatorio = $this->relatorio_model->buscarRelatorio($idRelatorioDescrip);

		$arrDados = array('arrRelatorio' => $arrRelatorio);

		$this->load->view('relatorio/ver_relatorio_view', $arrDados);
	}
}

