<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matricula_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }
    
    //-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar todas as matriculas
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function listarMatricula($ativo = '')
	{
		$result = $this->db->query("SELECT
										m.id_matricula,
										c.nome_curso,
										a.nome_aluno,
										e.nome_estagio,
										m.data_matricula,
										DATE_FORMAT(m.data_matricula,'%d/%m/%Y') AS data_matricula_formatada,
										m.ativo
									FROM
										matricula m
										JOIN aluno a ON (a.id_aluno = m.id_aluno)	      
										JOIN estagio e ON (e.id_estagio = m.id_estagio)
										JOIN curso c ON (c.id_curso = e.id_curso)    
									ORDER BY
										c.nome_curso");

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
	 * Funcao responsavel por incluir uma matricula
	 * 
	 * @param int $arrInfoMatricula
	 */
	public function incluirMatricula($arrInfoMatricula)
	{
		$this->db->insert('matricula', $arrInfoMatricula);
		return $this->db->insert_id();
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por incluir uma matricula turma (dia da semana e horario)
	 * 
	 * @param int $arrInfoDiaHoraAula
	 */
	public function incluirMatriculaTurma($arrInfoDiaHoraAula)
	{
		$this->db->insert('matricula_turma', $arrInfoDiaHoraAula);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar uma matricula
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function buscarMatricula($idMatricula)
	{
		$result = $this->db->query("SELECT
										m.id_matricula,
										e.id_curso,
										c.nome_curso,
										m.id_aluno,
										a.nome_aluno,
										m.id_estagio,
										e.nome_estagio,
										m.identificador_aluno,
										m.data_matricula,
										DATE_FORMAT(m.data_matricula,'%d/%m/%Y') AS data_matricula_formatada,
										DATE_FORMAT(m.data_inativo,'%d/%m/%Y') AS data_inativa_formatada,
										m.ativo
									FROM
										matricula m
										JOIN aluno a ON (a.id_aluno = m.id_aluno)	      
										JOIN estagio e ON (e.id_estagio = m.id_estagio)
										JOIN curso c ON (c.id_curso = e.id_curso)  
									WHERE
										m.id_matricula = {$idMatricula}
									ORDER BY
										c.nome_curso");

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
	 * Funcao responsavel por buscar uma matricula turma
	 * 
	 * @param type|int $ativo 
	 * @return array
	 */
	public function buscarMatriculaTurma($idMatricula)
	{
		$this->db->where('id_matricula', $idMatricula); 
		$this->db->select("dia_aula, TIME_FORMAT(horario_aula, '%H:%i') AS horario_aula_formatado");
		$result = $this->db->get('matricula_turma');

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
	 * Funcao responsavel por editar uma matricula
	 * 
	 * @param type $arrInfoMatricula 
	 * @param type $idMatricula 
	 * @return type
	 */
	public function editarMatricula($arrInfoMatricula, $idMatricula)
	{
		$this->db->where('id_matricula', $idMatricula);
		$this->db->update('matricula', $arrInfoMatricula);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por excluir os dias da semana e horarios cadastrados para a matricula do aluno
	 * @param type $idMatricula 
	 * @return type
	 */
	public function excluirDiaHoraAula($idMatricula)
	{
		$this->db->delete('matricula_turma', array('id_matricula' => $idMatricula));
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por verificar se o aluno ja eh matriculado em um curso
	 *
	 * @param [type] $idAluno
	 * @param [type] $idCurso
	 * @return void
	 */
	function verificaMatriculaAluno($idAluno, $idCurso)
	{
		$result = $this->db->query("SELECT
										m.id_matricula,
										a.nome_aluno,
										c.nome_curso,
										DATE_FORMAT(m.data_matricula,'%d/%m/%Y') AS data_matricula_formatada
									FROM
										matricula m
										JOIN estagio e ON (e.id_estagio = m.id_estagio)
										JOIN curso c ON (c.id_curso = e.id_curso)
										JOIN aluno a ON (a.id_aluno = m.id_aluno)
									WHERE
										m.id_aluno = {$idAluno}
									AND
										c.id_curso = {$idCurso}");

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