<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progresso_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }
    
    //-----------------------------------------------------------

	 /**
	  * Funcao responsavel por buscar os progessos estudo do aluno
	  *
	  * @param [type] $idCurso
	  * @param [type] $idAluno
	  * @return void
	  */
	public function buscaProgressoAluno($idCurso, $idAluno)
	{
		$result = $this->db->query("SELECT
										a.nome_aluno,
										c.nome_curso,
										p.id_progresso,
										e.nome_estagio,                                    
										p.qtde_folhas,
										p.data_lancamento,
										DATE_FORMAT(p.data_lancamento,'%d/%m/%Y') AS data_lancamento_formatada
									FROM
										progresso_estudo p
										JOIN estagio e ON (e.id_estagio = p.id_estagio)
										JOIN aluno a ON (a.id_aluno = p.id_aluno)
										JOIN curso c ON (c.id_curso = e.id_curso)
									WHERE
										e.id_curso = {$idCurso}
									AND 
										a.id_aluno = {$idAluno}
									ORDER BY
										p.data_lancamento DESC");

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
	 * Funcao responsavel por buscar um progresso estudo do aluno
	 * 
	 * @param int $idProgresso
	 */
	public function buscaInfoProgressoEstudoAluno($idProgresso)
	{
		$result = $this->db->get_where('progresso_estudo', array('id_progresso' => $idProgresso));
		
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
	 * Funcao responsavel por incluir um progresso estudo
	 * 
	 * @param int $arrInfoProgresso
	 */
	public function incluirProgresso($arrInfoProgresso)
	{
		$this->db->insert('progresso_estudo', $arrInfoProgresso);
	}
	
	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por editar progresso estudo
	 * 
	 * @param type $arrInfoProgresso 
	 * @param type $idProgresso 
	 * @return type
	 */
	public function editarProgresso($arrInfoProgresso, $idProgresso)
	{
		$this->db->where('id_progresso', $idProgresso);
		$this->db->update('progresso_estudo', $arrInfoProgresso);
	}

	//-----------------------------------------------------------

	 /**
	  * Funcao responsavel por excluir um progresso estudo
	  *
	  * @param [type] $idProgresso
	  * @return void
	  */
	public function excluirProgressoEstudo($idProgresso)
	{
		$this->db->delete('progresso_estudo', array('id_progresso' => $idProgresso));
	}

	//-----------------------------------------------------------
	
	/**
	 * Funcao responsavel por verificar se existe um progresso de estudo lancado para este aluno, neste curso e nesta data
	 *
	 * @param [type] $idCurso
	 * @param [type] $idAluno
	 * @param [type] $dtProgressoEstudo
	 * @return void
	 */
	public function verificaProgressoEstudo($idCurso, $idAluno, $dtProgressoEstudo)
	{
		$result = $this->db->query("SELECT
										a.nome_aluno,
										c.nome_curso,
										DATE_FORMAT(p.data_lancamento,'%d/%m/%Y') AS data_lancamento_formatada,
										u.nome_usuario
									FROM
										progresso_estudo p
										JOIN estagio e ON (e.id_estagio = p.id_estagio)
										JOIN aluno a ON (a.id_aluno = p.id_aluno)
										JOIN curso c ON (c.id_curso = e.id_curso)
										JOIN usuario u ON (u.id_usuario = p.id_usuario_cadastro)
									WHERE
										e.id_curso = {$idCurso}
									AND 
										a.id_aluno = {$idAluno}
									AND
									 	DATE(p.data_lancamento) LIKE '{$dtProgressoEstudo}%'");

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