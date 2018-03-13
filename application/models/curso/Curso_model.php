<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar todos os cursos
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function listarCursos($ativo = '')
	{
		$this->db->order_by("nome_curso", "asc");

		if(!empty($ativo))
		{
			$this->db->where('ativo', $ativo);
		}

		$result = $this->db->get('curso');

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