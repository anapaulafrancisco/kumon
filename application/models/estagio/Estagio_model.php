<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estagio_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }

    /**
     * Funcao responsavel por buscar os estagios do curso
     *
     * @param [type] $cursoID
     * @param [type] $alunoID
     * @param [type] $periodo
     * @return void
     */
    public function buscaEstagioCurso($idCurso)
    {

        $this->db->where('ativo', 1); 
        $this->db->where('id_curso', $idCurso); 
		$result = $this->db->get('estagio');

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
	 * Funcao responsavel buscar todos os estagio do curso
	 *
	 * @param [type] $anoAtual
	 * @return void
	 */
	public function listarEstagio($idCurso)
	{
		$this->db->where('e.id_curso', $idCurso);
		$this->db->join('curso c', 'c.id_curso = e.id_curso');
		$this->db->select("c.nome_curso, e.*");
		$result = $this->db->get('estagio e');

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
	 * Funcao responsavel por buscar informacoes do estagio
	 *
	 * @param [type] $idEstagio
	 * @return void
	 */
	public function buscaInfoEstagioCurso($idEstagio)
	{
		$this->db->where('id_estagio', $idEstagio);
		$result = $this->db->get('estagio');

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
	 * Funcao responsavel por incluir um estagio
	 * 
	 * @param int $arrInfoEstagio
	 */
	public function incluirEstagio($arrInfoEstagio)
	{
		$this->db->insert('estagio', $arrInfoEstagio);
	}
	
	//-----------------------------------------------------------

	 /**
	  * Funcao responsavel por editar um estagio
	  *
	  * @param [type] $arrInfoEstagio
	  * @param [type] $idEstagio
	  * @return void
	  */
	public function editarEstagio($arrInfoEstagio, $idEstagio)
	{
		$this->db->where('id_estagio', $idEstagio);
		$this->db->update('estagio', $arrInfoEstagio);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar informacoes do estagio
	 *
	 * @param [type] $idEstagio
	 * @return void
	 */
	public function verificaEstagioCurso($nomeEstagio, $idCurso)
	{
		$this->db->where('id_curso', $idCurso);
		$this->db->where('nome_estagio', $nomeEstagio);
		$result = $this->db->get('estagio');

		if (is_object($result) && $result->num_rows() > 0) 
		{
			return $result->row_array();
		} 
		else 
		{
			return array();
		}
	}
    
}