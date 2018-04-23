<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }
    
    //-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar todas as pessoas
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function listarPessoa($ativo = '')
	{
		$arrCredencial = get_credencial();
	
		if($arrCredencial['perfis'] != 1 || $arrCredencial['perfis'] != '1,2') //2->ORIENTADOR - 1,2 ->IMPLEMENTADOR/ORIENTADOR
		{
			$this->db->where('tipo', 'auxiliar');
		}

		$this->db->order_by("nome_pessoa", "asc");

		if(!empty($ativo))
		{
			$this->db->where('ativo', $ativo);
		}

		$this->db->select("pessoa.*, DATE_FORMAT(pessoa.data_cadastro,'%d/%m/%Y') AS data_cadastro_formatada");
		$result = $this->db->get('pessoa');
		
		if (is_object($result) && $result->num_rows() > 0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por incluir uma pessoa
	 * 
	 * @param int $arrInfoPessoa
	 */
	public function incluirPessoa($arrInfoPessoa)
	{
		$this->db->insert('pessoa', $arrInfoPessoa);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar uma pessoa
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function buscarPessoa($idPessoa)
	{
		$this->db->where('id_pessoa', $idPessoa); 
		$result = $this->db->get('pessoa');

		if (is_object($result) && $result->num_rows() > 0)
        {
            return $result->row_array();
        }
        else
        {
            return array();
        }
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por editar uma pessoa
	 * 
	 * @param type $arrInfoPessoa 
	 * @param type $idPessoa 
	 * @return type
	 */
	public function editarPessoa($arrInfoPessoa, $idPessoa)
	{
		$this->db->where('id_pessoa', $idPessoa);
		$this->db->update('pessoa', $arrInfoPessoa);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel retornar o total de usuario tipo auxiliar ativo
	 *
	 * @param [type] $anoAtual
	 * @return void
	 */
	public function buscaTotalAuxiliarAtivo()
	{
		$this->db->where('tipo', 'auxiliar'); 
		$this->db->where('ativo', 1); 
		$this->db->select("COUNT(id_pessoa) AS total_auxiliar_ativo");
		$result = $this->db->get('pessoa');
		
		if (is_object($result) && $result->num_rows() > 0)
        {
            return $result->row_array();
        }
        else
        {
            return array();
        }
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel retornar as pessoas de acordo com o tipo
	 *
	 * @param [type] $anoAtual
	 * @return void
	 */
	public function listarPessoaPorTipo($tipoPessoa)
	{
		$this->db->order_by("nome_pessoa", "asc");
		$this->db->where('tipo', $tipoPessoa); 
		$this->db->where('ativo', 1); 
		$result = $this->db->get('pessoa');
		
		if (is_object($result) && $result->num_rows() > 0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
	}
	
}