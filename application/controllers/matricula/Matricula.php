<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matricula extends CI_Controller {

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

	        $this->load->model('matricula/matricula_model');
	        $this->load->model('curso/curso_model');
	        $this->load->model('aluno/aluno_model');
	     	$this->load->model('unidade/unidade_model');
			$this->load->model('estagio/estagio_model');
		}
    	else
    	{
        	redirect('login');
    	}
    }
    
    //-----------------------------------------------------------

	public function index()
	{
		$arrMatricula = $this->matricula_model->listarMatricula();
		$arrDados = array('arrMatricula' => $arrMatricula);

		$this->load->view('matricula/lst_matricula_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para inserir a matricula
	 */
	public function formIncluirMatricula()
	{
		$arrCurso = $this->curso_model->listarCursos(1);
		$arrAluno = $this->aluno_model->listarAluno(1);
		$arrInfoUnidade = $this->unidade_model->buscarUnidade();

		$arrDados = array(
			'arrCurso' => $arrCurso, 
			'arrAluno' => $arrAluno,
			'arrInfoUnidade' => $arrInfoUnidade
		);

		$this->load->view('matricula/frm_incluir_matricula_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para editar a matricula
	 * 
	 * @param type $idMatricula 
	 */
	public function formEditarMatricula($idMatricula)
	{
		$arrCurso = $this->curso_model->listarCursos(1);
		$arrInfoUnidade = $this->unidade_model->buscarUnidade();

		$idMatriculaDescrip = base64_decode(urldecode($idMatricula));
		$arrMatricula = $this->matricula_model->buscarMatricula($idMatriculaDescrip);
		$arrMatriculaTurma = $this->matricula_model->buscarMatriculaTurma($idMatriculaDescrip);
		$arrInfoEstagio = $this->estagio_model->buscaEstagioCurso($arrMatricula['id_curso']);

		$arrDados = array(
			'arrCurso' => $arrCurso, 
			'arrInfoUnidade' => $arrInfoUnidade,
			'arrMatricula' => $arrMatricula, 
			'arrMatriculaTurma' => $arrMatriculaTurma,
			'arrInfoEstagio' => $arrInfoEstagio
		);
		$this->load->view('matricula/edt_matricula_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por incluir uma matricula
	 */
	public function incluirMatricula()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$arrDiaHora = array();

			if(isset($arrPost['chkDiaAulaSEG']))
			{	
				$arrDiaHora['diaHoraSEG']['dia'] = 'SEG'; 
				$arrDiaHora['diaHoraSEG']['hora'] = $arrPost['txtHoraAulaSEG']; 
			}
			
			if(isset($arrPost['chkDiaAulaTER']))
			{
				$arrDiaHora['diaHoraTER']['dia'] = 'TER'; 
				$arrDiaHora['diaHoraTER']['hora'] = $arrPost['txtHoraAulaTER']; 
			}

			if(isset($arrPost['chkDiaAulaQUA']))
			{
				$arrDiaHora['diaHoraQUA']['dia'] = 'QUA'; 
				$arrDiaHora['diaHoraQUA']['hora'] = $arrPost['txtHoraAulaQUA']; 
			}

			if(isset($arrPost['chkDiaAulaQUI']))
			{
				$arrDiaHora['diaHoraQUI']['dia'] = 'QUI'; 
				$arrDiaHora['diaHoraQUI']['hora'] = $arrPost['txtHoraAulaQUI']; 
			}

			if(isset($arrPost['chkDiaAulaSEX']))
			{
				$arrDiaHora['diaHoraSEX']['dia'] = 'SEX'; 
				$arrDiaHora['diaHoraSEX']['hora'] = $arrPost['txtHoraAulaSEX']; 
			}
			
			$this->form_validation->set_rules('sltCurso', 'Curso', 'required');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->formIncluirMatricula();
			}
			else
			{
				$arrInfoMatriculaAluno = $this->matricula_model->verificaMatriculaAluno($arrPost['sltAluno'], $arrPost['sltCurso']);

				if($arrInfoMatriculaAluno)
				{
					Notificacao::setNotificacao("Aluno já foi matriculado para este curso! (Aluno: {$arrInfoMatriculaAluno['nome_aluno']}, Curso: {$arrInfoMatriculaAluno['nome_curso']}, Data Matícula: {$arrInfoMatriculaAluno['data_matricula_formatada']})", Notificacao::$NOTIFICACAO_ERRO);
					redirect('matricula/gerenciar');
				}

				$arrInfoMatricula = array(
					'id_aluno' => $arrPost['sltAluno'], 
					'id_estagio' => $arrPost['sltEstagio'],
					'data_matricula' => implode("-", array_reverse(explode("/", $arrPost['txtDataMatricula']))),
					'ativo' => $arrPost['rdoStatusMatricula'],
					'id_usuario_cadastro' => $this->credencial['id_usuario'],
					'data_cadastro' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$idMatricula = $this->matricula_model->incluirMatricula($arrInfoMatricula);

				foreach ($arrDiaHora as $infoAula)
				{
					$arrInfoDiaHoraAula = array(
						'id_matricula' => $idMatricula,
						'dia_aula' => $infoAula['dia'],
						'horario_aula' => $infoAula['hora']
					);

					$this->matricula_model->incluirMatriculaTurma($arrInfoDiaHoraAula);
				}

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao incluir matrícula.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('matricula/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Matrícula incluída com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('matricula/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por exibir uma matricula
	 * 
	 * @param type $idMatricula
	 */
	public function ver($idMatricula)
	{
		$idMatriculaDescrip = base64_decode(urldecode($idMatricula));
		$arrMatricula = $this->matricula_model->buscarMatricula($idMatriculaDescrip);
		$arrMatriculaTurma = $this->matricula_model->buscarMatriculaTurma($idMatriculaDescrip);
		
		$arrDados = array('arrMatricula' => $arrMatricula, 'arrMatriculaTurma' => $arrMatriculaTurma);
		$this->load->view('matricula/ver_matricula_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por editar uma matricula
	 */
	public function editarMatricula()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
	
			$arrDiaHora = array();

			if(isset($arrPost['chkDiaAulaSEG']))
			{	
				$arrDiaHora['diaHoraSEG']['dia'] = 'SEG'; 
				$arrDiaHora['diaHoraSEG']['hora'] = $arrPost['txtHoraAulaSEG']; 
			}
			
			if(isset($arrPost['chkDiaAulaTER']))
			{
				$arrDiaHora['diaHoraTER']['dia'] = 'TER'; 
				$arrDiaHora['diaHoraTER']['hora'] = $arrPost['txtHoraAulaTER']; 
			}

			if(isset($arrPost['chkDiaAulaQUA']))
			{
				$arrDiaHora['diaHoraQUA']['dia'] = 'QUA'; 
				$arrDiaHora['diaHoraQUA']['hora'] = $arrPost['txtHoraAulaQUA']; 
			}

			if(isset($arrPost['chkDiaAulaQUI']))
			{
				$arrDiaHora['diaHoraQUI']['dia'] = 'QUI'; 
				$arrDiaHora['diaHoraQUI']['hora'] = $arrPost['txtHoraAulaQUI']; 
			}

			if(isset($arrPost['chkDiaAulaSEX']))
			{
				$arrDiaHora['diaHoraSEX']['dia'] = 'SEX'; 
				$arrDiaHora['diaHoraSEX']['hora'] = $arrPost['txtHoraAulaSEX']; 
			}
			
			$idMatriculaDescrip = base64_decode(urldecode($arrPost['hddIdMatricula']));

			$this->form_validation->set_rules('sltCurso', 'Curso', 'required');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->formEditarMatricula($arrPost['hddIdMatricula']);
			}
			else
			{
				$dataInativo = null;
				if(!$arrPost['rdoStatusMatricula'])
				{
					$dataInativo = implode("-", array_reverse(explode("/", $arrPost['txtDataInativa'])));
				}
				$arrInfoMatricula = array(	
					'id_estagio' => $arrPost['sltEstagio'],
					'data_matricula' => implode("-", array_reverse(explode("/", $arrPost['txtDataMatricula']))),
					'ativo' => $arrPost['rdoStatusMatricula'],
					'data_inativo' => $dataInativo,
					'id_usuario_alteracao' => $this->credencial['id_usuario'],
					'data_alteracao' => date('Y-m-d H:i:s')
				);
		
				$this->db->trans_begin();

				$this->matricula_model->editarMatricula($arrInfoMatricula, $idMatriculaDescrip);
				
				$this->matricula_model->excluirDiaHoraAula($idMatriculaDescrip);

				foreach ($arrDiaHora as $infoAula)
				{
					$arrInfoDiaHoraAula = array(
						'id_matricula' => $idMatriculaDescrip,
						'dia_aula' => $infoAula['dia'],
						'horario_aula' => $infoAula['hora']
					);

					$this->matricula_model->incluirMatriculaTurma($arrInfoDiaHoraAula);
				}

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar matrícula.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('matricula/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Matrícula editada com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('matricula/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por listar todos os dias/horarios dos alunos matriculados
	 *
	 * @return void
	 */
	public function listarHorario()
	{
		$whereFiltro = '';
		$where = array();

		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
	
			$this->session->set_userdata(array('post_filtro_horario' => $arrPost));	

			if(!empty($arrPost['sltCurso']))
			{
				$where[] = "AND c.id_curso = " . $arrPost['sltCurso'];	
			}

			if(!empty($arrPost['sltAluno']))
			{
				$where[] = "AND a.id_aluno = " . $arrPost['sltAluno'];	
			}
			
			//tentar fazer com select multiplo
			if(!empty($arrPost['sltDiaSemana']))
			{
				$where[] = "AND mt.dia_aula LIKE '%" . $arrPost['sltDiaSemana'] . "%'";	
			}
			
			if(!empty($arrPost['txtHora']))
			{
				$where[] = "AND mt.horario_aula = '" . $arrPost['txtHora'] . "'";	
			}

			if(isset($arrPost['btnLimparFiltro']))
			{
				$this->session->unset_userdata('post_filtro_horario');
    		 	$where = array();
		 	}
		}	
		else
		{
			if($this->session->has_userdata('post_filtro_horario'))
			{
				$arrPost = $this->session->userdata('post_filtro_horario');

				if(!empty($arrPost['sltCurso']))
				{
					$where[] = "AND c.id_curso = " . $arrPost['sltCurso'];	
				}

				if(!empty($arrPost['sltAluno']))
				{
					$where[] = "AND a.id_aluno = " . $arrPost['sltAluno'];	
				}
				
				//tentar fazer com select multiplo
				if(!empty($arrPost['sltDiaSemana']))
				{
					$where[] = "AND mt.dia_aula LIKE '%" . $arrPost['sltDiaSemana'] . "%'";	
				}

				if(!empty($arrPost['txtHora']))
				{
					$where[] = "AND mt.horario_aula = '" . $arrPost['txtHora'] . "'";	
				}
			}
		}

		if (count($where) > 0)
        {
            $whereFiltro = implode("\n ", $where);
        }
		
		$arrInfoHorario = $this->matricula_model->listarHorarioAluno($whereFiltro);
		$arrCurso = $this->curso_model->listarCursos(1);
		$arrAluno = $this->matricula_model->buscaAlunosMatriculados(1);
		$arrInfoUnidade = $this->unidade_model->buscarUnidade();
		
		$arrDados = array(
			'arrInfoHorario' => $arrInfoHorario,
			'arrCurso' => $arrCurso,
			'arrAluno' => $arrAluno,
			'arrInfoUnidade' => $arrInfoUnidade
		);

		$this->load->view('matricula/lst_horario_view', $arrDados);
	}
}   
