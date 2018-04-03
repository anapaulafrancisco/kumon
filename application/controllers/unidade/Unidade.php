<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidade extends CI_Controller {

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

	        $this->load->model('unidade/unidade_model');
		}
    	else
    	{
        	redirect('login');
    	}
    }

    /**
	 * Funcao responsavel por chamar o formulario para editar a unidade
	 */
	public function formEditarUnidade()
	{
		$arrUnidade = $this->unidade_model->buscarUnidade();

		$arrDados = array('arrUnidade' => $arrUnidade);
		$this->load->view('unidade/edt_unidade_view', $arrDados);
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por editar a unidade
	 */
	public function editarUnidade()
	{
		if($this->input->post(NULL, TRUE))
		{
			$arrPost = $this->input->post();
			
			$idUnidadeDescrip = base64_decode(urldecode($arrPost['hddIdUnidade']));

			$this->form_validation->set_rules('txtNomeUnidade', 'Nome', 'trim|required|min_length[2]');

			$this->form_validation->set_error_delimiters("<p style='color: #E74C3C;'>", "</p>");

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('unidade/edt_unidade_view');
			}
			else
			{
				$diasFuncionamento = '';
				if(isset($arrPost['chkDiaFuncionamento']))
				{
					$diasFuncionamento = implode(',', $arrPost['chkDiaFuncionamento']);
				}

				$arrInfoUnidade = array(
					'nome_unidade' => mb_strtoupper(trim($arrPost['txtNomeUnidade'])), 
					'nome_fantasia' => mb_strtoupper(trim($arrPost['txtNomeFantasia'])),
					'razao_social' => mb_strtoupper(trim($arrPost['txtRazaoSocial'])),
					'cnpj' => trim($arrPost['txtCNPJ']),
					'inscricao_estadual' => trim($arrPost['txtInscEstadual']),
					'filial_responsavel' => mb_strtoupper(trim($arrPost['txtFilialResp'])),
					'email' => strtolower(trim($arrPost['txtEmail'])),
					'telefone_fixo' => trim($arrPost['txtTelFixo']),
					'telefone_celular' => trim($arrPost['txtCelular']),
					'cep' => trim($arrPost['txtCEP']),
					'endereco' => mb_strtoupper(trim($arrPost['txtEndereco'])),
					'bairro' => mb_strtoupper(trim($arrPost['txtBairro'])),
					'cidade' => mb_strtoupper(trim($arrPost['txtCidade'])),
					'estado' => $arrPost['sltEstado'],
					'dias_semana' => $diasFuncionamento,
					'horario_inicio' => $arrPost['txtHoraInicio'],
					'horario_fim' => $arrPost['txtHoraFim'],
					'id_usuario_alteracao' => $this->credencial['id_usuario'],
					'data_alteracao' => date('Y-m-d H:i:s')
				);

				$this->db->trans_begin();

				$this->unidade_model->editarUnidade($arrInfoUnidade, $idUnidadeDescrip);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					Notificacao::setNotificacao('Erro ao editar unidade.', Notificacao::$NOTIFICACAO_ERRO);
					redirect('unidade/editar');
				}
				else
				{
				    $this->db->trans_commit();
				    Notificacao::setNotificacao('Unidade editada com sucesso!', Notificacao::$NOTIFICACAO_SUCESSO);
				    redirect('unidade/editar');
				}	
			}
		}
	}
}