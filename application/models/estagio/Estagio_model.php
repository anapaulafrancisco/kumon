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
    
}