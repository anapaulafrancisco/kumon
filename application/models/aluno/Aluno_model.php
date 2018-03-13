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

	//-----------------------------------------------------------

	/**
	  * Funcao responsavel por buscar os alunos de acordo com o curso selecionado
	  *
	  * @param [type] $idCurso
	  * @return void
	  */
	public function buscaAlunoCurso($idCurso)
	{	
		$this->db->order_by("a.nome_aluno", "asc");
		$this->db->where('c.id_curso', $idCurso); 
		$this->db->where('m.ativo', 1); 
		$this->db->join('aluno a', 'a.id_aluno = m.id_aluno');
		$this->db->join('estagio e', 'e.id_estagio = m.id_estagio');
		$this->db->join('curso c', 'c.id_curso = e.id_curso');
		$this->db->select("a.nome_aluno, a.id_aluno");
		$result = $this->db->get('matricula m');

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