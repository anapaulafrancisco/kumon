<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }
    
    //-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar todos os alunos
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function listarAluno($ativo = '')
	{
		$this->db->order_by("nome_aluno", "asc");

		if(!empty($ativo))
		{
			$this->db->where('ativo', $ativo);
		}

		$this->db->select("aluno.*, DATE_FORMAT(aluno.data_cadastro,'%d/%m/%Y') AS data_cadastro_formatada");
		$result = $this->db->get('aluno');

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