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
			$this->load->model('matricula/matricula_model');
			$this->load->model('pessoa/pessoa_model');
		}
    	else
    	{
        	redirect('login');
    	}
	}
	
	public function index()
	{
		$arrAluno = $this->aluno_model->listarAluno(1);
		$arrMatricula = $this->matricula_model->listarMatricula(1);

		$qtdeAluno = count($arrAluno);
		$qtdeMatricula = count($arrMatricula);
		
		$anoAtual = date('Y');
		$arrMatriculaInativa = $this->matricula_model->buscaTotalMatriculaInativa($anoAtual);

		$arrAuxiliarAtivo = $this->pessoa_model->buscaTotalAuxiliarAtivo();

		$periodo = date('Y-m-01', strtotime("-12 month")); //ultimos 12 meses
		$arrMatriculaAtivaInativa = $this->matricula_model->relatorioAtivoInativo($periodo);

		$qtdeCursoAluno = '';
		$arrInfoMatriculaAluno = array();
		if($this->credencial['perfis_nomes'] == 'aluno')
		{
			//busca aluno ID pelo email do usuario logado
			$arrIdAluno = $this->aluno_model->buscaIDAlunoPorEmail($this->credencial['email']);

			//busca os cursos do aluno
			$arrCurso = $this->matricula_model->buscaCursoAluno($arrIdAluno['id_aluno']);
			$qtdeCursoAluno = count($arrCurso);

			$arrInfoMatriculaAluno = $this->matricula_model->buscaInfoMatriculaAluno($arrIdAluno['id_aluno']);
		}
	
		$arrDados = array(
			'qtdeAluno' => $qtdeAluno, 
			'qtdeMatricula' => $qtdeMatricula, 
			'qtdeMatriculaInativa' => $arrMatriculaInativa['total_inativa'], 
			'qtdeAuxiliarAtivo' => $arrAuxiliarAtivo['total_auxiliar_ativo'],
			'graficoEntradaSaida' => $arrMatriculaAtivaInativa,
			'qtdeCursoAluno' => $qtdeCursoAluno,
			'arrInfoMatriculaAluno' => $arrInfoMatriculaAluno
		);
		
		$this->load->view('home_view', $arrDados);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */

