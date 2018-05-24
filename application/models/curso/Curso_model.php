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

		$this->db->select("*, DATE_FORMAT(data_curso,'%d/%m/%Y') AS data_curso_formatada");
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

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por incluir um curso
	 * 
	 * @param int $arrInfoCurso
	 */
	public function incluirCurso($arrInfoCurso)
	{
		$this->db->insert('curso', $arrInfoCurso);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar um curso
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function buscarCurso($idCurso)
	{
		$this->db->where('id_curso', $idCurso);
		$this->db->select("*, DATE_FORMAT(data_curso,'%d/%m/%Y') AS data_curso_formatada");
		$result = $this->db->get('curso');

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
	 * Funcao responsavel por editar um curso
	 * 
	 * @param type $arrInfoCurso 
	 * @param type $idCurso 
	 * @return type
	 */
	public function editarCurso($arrInfoCurso, $idCurso)
	{
		$this->db->where('id_curso', $idCurso);
		$this->db->update('curso', $arrInfoCurso);
	}
}