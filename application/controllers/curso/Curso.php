<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {

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

			$this->load->model('curso/curso_model');
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
		$arrCurso = $this->curso_model->listarCursos();
		$arrDados = array('arrCurso' => $arrCurso);

		$this->load->view('curso/lst_curso_view', $arrDados);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para inserir o curso
	 */
	public function formIncluirCurso()
	{
		$this->load->view('curso/frm_incluir_curso_view');
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para editar o curso
	 * 
	 * @param type $idCurso 
	 */
	public function formEditarCurso($idCurso)
	{
		$idCursoDescrip = base64_decode(urldecode($idCurso));
		$arrCurso = $this->curso_model->buscarCurso($idCursoDescrip);

		$arrDados = array('arrCurso' => $arrCurso);
		$this->load->view('curso/edt_curso_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por incluir um curso
	 */
	public function incluirCurso()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();

			$this->form_validation->set_rules('txtNomeCurso', 'Nome Curso', 'trim|required|min_length[2]|is_unique[curso.nome_curso]');
			$this->form_validation->set_rules('txtDataCurso', 'Data', 'trim|required');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('curso/frm_incluir_curso_view');
			}
			else
			{
				$arrInfoCurso = array(
					'nome_curso' => trim($arrPost['txtNomeCurso']), 
					'data_curso' => implode("-", array_reverse(explode("/", $arrPost['txtDataCurso']))),
					'ativo' => 1,
					'id_usuario_cadastro' => $this->credencial['id_usuario'],
					'data_cadastro' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->curso_model->incluirCurso($arrInfoCurso);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao incluir curso.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('curso/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Curso incluído com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('curso/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por editar um curso
	 */
	public function editarCurso()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$idCursoDescrip = base64_decode(urldecode($arrPost['hddIdCurso']));
			
			$this->form_validation->set_rules('txtDataCurso', 'Data', 'trim|required');

			if ($arrPost['hddNomeCurso'] != trim($arrPost['txtNomeCurso'])) 
			{
				$this->form_validation->set_rules('txtNomeCurso', 'Nome Curso', 'trim|required|min_length[2]|is_unique[curso.nome_curso]');
			}

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('curso/edt_curso_view');
			}
			else
			{
				$arrInfoCurso = array(
					'nome_curso' => trim($arrPost['txtNomeCurso']),
					'data_curso' => implode("-", array_reverse(explode("/", $arrPost['txtDataCurso']))),
					'ativo' => $arrPost['rdoStatusCurso'],
					'id_usuario_alteracao' => $this->credencial['id_usuario'],
					'data_alteracao' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->curso_model->editarCurso($arrInfoCurso, $idCursoDescrip);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar curso.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('curso/gerenciar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Curso editado com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('curso/gerenciar');
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por exibir os estagios
	 * 
	 * @param type $idCurso 
	 */
	public function verEstagio($idCurso)
	{
		$idCursoDescrip = base64_decode(urldecode($idCurso));
		$arrEstagioCurso = $this->estagio_model->listarEstagio($idCursoDescrip);

		$arrDados = array('arrEstagioCurso' => $arrEstagioCurso, 'idCurso' => $idCursoDescrip);
		$this->load->view('curso/ver_estagio_view', $arrDados);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por editar o estagio
	*
	* @return void
	*/
	public function editarEstagio()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();

		/* 	echo '<pre>';
			print_r($arrPost);
			echo '</pre>';
			

    [txtNomeEstagio] => 2A
    [txtQtdeBloco] => 20
    [txtQtdeFolha] => 200
    [txtNumeracaoBloco] => 10
    [rdoStatusEstagio] => 1
    [hddEstagioIDEditar] => 1
    [hddCursoID] => MQ%3D%3D
)
			die(); */
			$idEstagio = $arrPost['hddEstagioIDEditar'];
			
			$this->form_validation->set_rules('txtNomeEstagio', 'Nome estágio', 'trim|required');
			$this->form_validation->set_rules('txtQtdeBloco', 'Qtde bloco', 'trim|required');
			$this->form_validation->set_rules('txtQtdeFolha', 'Qtde folha', 'trim|required');
			$this->form_validation->set_rules('txtNumeracaoBloco', 'Numeração bloco', 'trim|required');
			$this->form_validation->set_rules('rdoStatusEstagio', 'Status', 'required');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->verEstagio($arrPost['hddCursoID']);
			}
			else
			{
				$arrInfoEstagio = array(
					'nome_estagio' => trim($arrPost['txtNomeEstagio']),
					'qtde_bloco' => trim($arrPost['txtQtdeBloco']),
					'qtde_folha' => trim($arrPost['txtQtdeFolha']),
					'numeracao_bloco' => trim($arrPost['txtNumeracaoBloco']),
					'ativo' => $arrPost['rdoStatusEstagio'],
					'id_usuario_alteracao' => $this->credencial['id_usuario'],
					'data_alteracao' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->estagio_model->editarEstagio($arrInfoEstagio, $idEstagio);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar estágio.', Notificacao::$NOTIFICACAO_ERRO);
					$this->verEstagio($arrPost['hddCursoID']);
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Estágio editado com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
					$this->verEstagio($arrPost['hddCursoID']);
				}	
			}
		}
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por chamar o formulario para inserir o estagio
	 */
	public function formIncluirEstagio($idCursoCrip)
	{
		$this->load->view('curso/frm_incluir_estagio_view', array('idCursoCrip' => $idCursoCrip));
	}
	
	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por incluir um estagio
	 */
	public function incluirEstagio()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			$idCursoDescrip = base64_decode(urldecode($arrPost['hddCursoID']));

			$this->form_validation->set_rules('txtNomeEstagio', 'Nome Estágio', 'trim|required');
			$this->form_validation->set_rules('txtQtdeBloco', 'Qtde Bloco', 'trim|required');
			$this->form_validation->set_rules('txtQtdeFolha', 'Qtde Folha', 'trim|required');
			$this->form_validation->set_rules('txtNumeracaoBloco', 'Numeração bloco', 'trim|required');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->formIncluirEstagio($arrPost['hddCursoID']);
			}
			else
			{
				$arrInfoEstagioCurso = $this->estagio_model->verificaEstagioCurso($arrPost['txtNomeEstagio'], $idCursoDescrip);

				if($arrInfoEstagioCurso)
				{
					Notificacao::setNotificacao("Estágio já cadastrado para este curso!", Notificacao::$NOTIFICACAO_ERRO);
					redirect('curso/gerenciar');
				}

				$arrInfoEstagio = array(
					'id_curso' => $idCursoDescrip,
					'nome_estagio' => trim($arrPost['txtNomeEstagio']), 
					'qtde_bloco' => trim($arrPost['txtQtdeBloco']), 
					'qtde_folha' => trim($arrPost['txtQtdeFolha']), 
					'numeracao_bloco' => trim($arrPost['txtNumeracaoBloco']), 
					'ativo' => $arrPost['rdoStatusEstagio'],
					'id_usuario_cadastro' => $this->credencial['id_usuario'],
					'data_cadastro' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->estagio_model->incluirEstagio($arrInfoEstagio);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao incluir estágio.', Notificacao::$NOTIFICACAO_ERRO);
					$this->verEstagio($arrPost['hddCursoID']);
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Estágio incluído com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
					$this->verEstagio($arrPost['hddCursoID']);
				}	
			}
		}
	}

}   