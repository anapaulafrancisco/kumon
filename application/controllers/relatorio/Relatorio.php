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
			$this->load->model('matricula/matricula_model');
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

		$arrCurso = $this->curso_model->listarCursos(1);
		
		$arrDados = array(
			'arrCurso' => $arrCurso 
		);

		//se for aluno
		if($this->credencial['perfis_nomes'] == 'aluno')
		{
			//busca aluno ID pelo email do usuario logado
			$arrIdAluno = $this->aluno_model->buscaIDAlunoPorEmail($this->credencial['email']);

			//busca os cursos do aluno
			$arrCurso = $this->matricula_model->buscaCursoAluno($arrIdAluno['id_aluno']);

			$arrDados = array(
				'arrCurso' => $arrCurso
			);	
		}

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
				
				$arrInfoMatricula = $this->matricula_model->verificaMatriculaAluno($arrPost['sltAluno'], $arrPost['sltCurso']);
				$arrMatriculaTurma = $this->matricula_model->buscarMatriculaTurma($arrInfoMatricula['id_matricula']);

				$periodo = date('Y-m-01', strtotime("-{$arrPost['sltPeriodo']} month"));
	
				$arrInfoRelFolhaMes = $this->relatorio_model->relFolhaMes($arrPost['sltCurso'], $arrPost['sltAluno'], $periodo);

				if(isset($arrInfoRelFolhaMes['info']))
				{
					$arrInfoPremiacaoAlmejada = array();
					foreach($arrInfoRelFolhaMes['info'] as $infoRel)
					{
						$sequenciaPremiacao = $infoRel['sequencia_premiacao'] + 1;
						$arrInfoPremiacaoAlmejada[] = $this->relatorio_model->buscaPremiacaoAlmejada($arrPost['sltCurso'], $infoRel['id_serie'], $sequenciaPremiacao);
						
					}
		
					foreach($arrInfoPremiacaoAlmejada as $indice => $infoAlmejada)
					{
						array_push($arrInfoRelFolhaMes['info'][$indice], $infoAlmejada['estagio_folhas'], $infoAlmejada['classificacao']);
					}
					
				}

				$arrDados['arrInfoRelFolhaMes'] = $arrInfoRelFolhaMes;
				$arrDados['arrInfoAluno'] = $arrInfoAluno;
				$arrDados['arrMatriculaTurma'] = $arrMatriculaTurma;
			}
		}
		
		$this->load->view('relatorio/lst_relatorio_view', $arrDados);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por gerar o relatorio de saldo de aluno
	 *
	 * @return void
	 */
	public function relSaldoAluno()
	{
		if($this->session->has_userdata('post_filtro_saldo'))
		{
			$this->session->unset_userdata('post_filtro_saldo');
		}

		$arrMes = array(
			'01' => 'JANEIRO', '02' => 'FEVEREIRO', '03' => 'MARÇO', '04' => 'ABRIL',
			'05' => 'MAIO', '06' => 'JUNHO', '07' => 'JULHO', '08' => 'AGOSTO',
			'09' => 'SETEMBRO', '10' => 'OUTUBRO', '11' => 'NOVEMBRO', '12' => 'DEZEMBRO'
		);
		
		$arrDados['arrMes'] = $arrMes;
		$arrDados['arrSaldoAlunoAtivoMes'] = null;
		$arrDados['arrSaldoAlunoInativoMes'] = null;
		$arrDados['mesAnoSelecionado'] = null;
		
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
	
			if(isset($arrPost['btnLimparFiltro']))
			{
				$this->session->unset_userdata('post_filtro_saldo');
			}
			else
			{
				$this->session->set_userdata(array('post_filtro_saldo' => $arrPost));	
				
				$anoMesSelecionado = $arrPost['txtAno'] . '-' . $arrPost['sltMes'];

				//ativo
				$arrSaldoAlunoAtivo = $this->matricula_model->relatorioSaldoAluno(1, $anoMesSelecionado);

				$arrSaldoAlunoAtivoMes = array();
				foreach($arrSaldoAlunoAtivo as $saldo)
				{
					$arrSaldoAlunoAtivoMes[$saldo['nome_curso']][] = $saldo;
				}

				//inativo
				$arrSaldoAlunoInativo = $this->matricula_model->relatorioSaldoAluno(0, $anoMesSelecionado);

				$arrSaldoAlunoInativoMes = array();
				foreach($arrSaldoAlunoInativo as $saldo)
				{
					$arrSaldoAlunoInativoMes[$saldo['nome_curso']][] = $saldo;
				}

				//ativo total geral ate dia/mes/ano selecionado
				$data = new DateTime($anoMesSelecionado .'-01'); 
 				$buscaAtivoData = $data->format('Y-m-t'); //pega o ultimo dia do mes/ano selecionado
				$arrTotalGeralAtivo = $this->matricula_model->totalGeralAtivo($buscaAtivoData);
	
				$arrDados['arrSaldoAlunoAtivoMes'] = $arrSaldoAlunoAtivoMes;
				$arrDados['totalEntrada'] = count($arrSaldoAlunoAtivo);

				$arrDados['arrSaldoAlunoInativoMes'] = $arrSaldoAlunoInativoMes;
				$arrDados['totalSaida'] = count($arrSaldoAlunoInativo);
				
				$arrDados['mesAnoSelecionado'] = $arrMes[$arrPost['sltMes']] . ' de ' . $arrPost['txtAno'];

				$arrDados['totalGeralAtivo'] = $arrTotalGeralAtivo['total_matricula_ativa'];
			}
		}
		
		$this->load->view('relatorio/lst_rel_saldo_aluno_view', $arrDados);
	}

}

