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
		$where = '';
		if(!empty($ativo))
		{
			$where = "WHERE m.ativo = {$ativo}";
		}

		$result = $this->db->query("SELECT
										m.id_matricula,
										c.id_curso,
										c.nome_curso,
										a.id_aluno,
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
										{$where}
									ORDER BY
										a.nome_aluno");

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
	public function verificaMatriculaAluno($idAluno, $idCurso)
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

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel retornar o total de matricula inativa do ano
	 *
	 * @param [type] $anoAtual
	 * @return void
	 */
	public function buscaTotalMatriculaInativa($anoAtual)
	{
		$this->db->where('YEAR(data_inativo)', $anoAtual); 
		$this->db->where('ativo', 0); 
		$this->db->select("COUNT(id_matricula) AS total_inativa");
		$result = $this->db->get('matricula');

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
	 * Funcao responsavel por listar matriculas ativas e inativas durante os ultimos 12 meses
	 *
	 * @param [type] $periodo
	 * @return void
	 */
	public function relatorioAtivoInativo($periodo)
	{
		$this->db->query("SET lc_time_names = 'pt_BR'");
		$result = $this->db->query("SELECT
										-- DATE_FORMAT(data_matricula, '%b') AS mes,
										CASE
										WHEN ativo = 1 THEN DATE_FORMAT(data_matricula, '%b')
										ELSE DATE_FORMAT(data_inativo, '%b')
										END AS mes,
	
										SUM(
											CASE 
												WHEN ativo = 1 THEN 1
												ELSE 0
											END	
										) AS total_ativo,
										SUM(
											CASE WHEN ativo = 0 THEN 1
												ELSE 0
											END	
										) AS total_inativo									
									FROM
										matricula
									WHERE
										data_matricula >= '{$periodo}' 		
									GROUP BY	
										CASE	
											WHEN data_inativo IS NOT NULL THEN DATE_FORMAT(data_inativo, '%Y-%m') 
											ELSE DATE_FORMAT(data_matricula, '%Y-%m') 
										END	
									ORDER BY
										 CASE
											WHEN ativo = 1 THEN data_matricula
											ELSE data_inativo
											END");

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
	 * Funcao responsavel por buscar os cursos que o aluno eh matriculado
	 *
	 * @param [type] $idAluno
	 * @return void
	 */
	public function buscaCursoAluno($idAluno)
	{
		$result = $this->db->query("SELECT
										a.id_aluno,
										a.nome_aluno,
										c.id_curso,
										c.nome_curso
									FROM
										matricula m
										JOIN estagio e ON (e.id_estagio = m.id_estagio)
										JOIN curso c ON (c.id_curso = e.id_curso)
										JOIN aluno a ON (a.id_aluno = m.id_aluno)
									WHERE
										m.id_aluno = {$idAluno}");

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
	 * Funcao responsavel por buscar informacoes da matricula do aluno - exibidas no dashboard
	 *
	 * @param [type] $idAluno
	 * @return void
	 */
	public function buscaInfoMatriculaAluno($idAluno)
	{
		$result = $this->db->query("SELECT
										a.nome_aluno,
										s.nivel,
										s.nome_serie,
										c.nome_curso,
										DATE_FORMAT(m.data_matricula,'%d/%m/%Y') AS data_matricula_formatada,
										GROUP_CONCAT(DISTINCT mt.dia_aula, ' - ', TIME_FORMAT(mt.horario_aula, '%H:%i') ORDER BY mt.id_matricula_turma SEPARATOR ') (') AS dia_hora_aula	
									FROM
										matricula m
										JOIN aluno a ON (a.id_aluno = m.id_aluno)
										JOIN serie s ON (s.id_serie = a.id_serie)
										JOIN estagio e ON (e.id_estagio = m.id_estagio)
										JOIN curso c ON (c.id_curso = e.id_curso)
										JOIN matricula_turma mt ON (mt.id_matricula = m.id_matricula)
									WHERE	
										m.id_aluno = {$idAluno}
									AND
										m.ativo = 1	
									GROUP BY
										m.id_matricula
									ORDER BY
										m.data_matricula DESC");

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
	 * Funcao responsavel por buscar informacoes da matricula de acordo com o filtro
	 *
	 * @param string $whereFiltro
	 * @return void
	 */
	public function listarHorarioAluno($whereFiltro = '')
	{
		$filtrar = empty($whereFiltro) ? '' : $whereFiltro;

		$result = $this->db->query("SELECT
										c.id_curso,
										c.nome_curso,
										a.nome_aluno,
										GROUP_CONCAT(DISTINCT mt.dia_aula, ' - ', TIME_FORMAT(mt.horario_aula, '%H:%i') ORDER BY
										mt.id_matricula_turma SEPARATOR ') (') AS dia_hora_aula	
									FROM
										matricula m
										JOIN aluno a ON (a.id_aluno = m.id_aluno)
										JOIN estagio e ON (e.id_estagio = m.id_estagio)
										JOIN curso c ON (c.id_curso = e.id_curso)
										JOIN matricula_turma mt ON (mt.id_matricula = m.id_matricula)
									WHERE
										m.ativo = 1
									{$filtrar}	
									GROUP BY
										m.id_matricula
									ORDER BY
										c.nome_curso, a.nome_aluno");
	
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
	 * Funcao responsavel por buscar os alunos matriculados
	 *
	 * @return void
	 */
	public function buscaAlunosMatriculados($ativo = '')
	{
		$where = '';
		if(!empty($ativo))
		{
			$where = "WHERE m.ativo = {$ativo}";
		}

		$result = $this->db->query("SELECT
										DISTINCT (a.id_aluno),
										a.nome_aluno
									FROM
										matricula m
										JOIN aluno a ON (a.id_aluno = m.id_aluno)
									{$where}");

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
	 * Funcao responsavel por listar matriculas atuv
	 *
	 * @param [type] $status
	 * @param [type] $anoMesMatricula
	 * @return void
	 */
	public function relatorioSaldoAluno($status, $anoMesMatricula)
	{
		$campoData = 'm.data_matricula';

		if(!$status)
		{
			$campoData = 'm.data_inativo';
		}

		$result = $this->db->query("SELECT
										c.id_curso,
										c.nome_curso,
										a.nome_aluno,
										DATE_FORMAT(m.data_matricula,'%d/%m/%Y') AS data_matricula_formatada,
										DATE_FORMAT(m.data_inativo,'%d/%m/%Y') AS data_inativo_formatada
									FROM
										matricula m
										JOIN aluno a ON (a.id_aluno = m.id_aluno)	      
										JOIN estagio e ON (e.id_estagio = m.id_estagio)
										JOIN curso c ON (c.id_curso = e.id_curso)    
									WHERE
										m.ativo = {$status}	
									AND
										{$campoData} LIKE '%{$anoMesMatricula}%'
									ORDER BY
										{$campoData}");

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
	 * Funcao responsavel retornar o total de matricula ativas ate a data atual selecionada
	 *
	 * @param [type] $buscaAtivoData
	 * @return void
	 */
	public function totalGeralAtivo($buscaAtivoData)
	{
		$this->db->where('data_matricula <=', $buscaAtivoData); 
		$this->db->where('ativo', 1);
		$this->db->select("COUNT(id_matricula) AS total_matricula_ativa");
		$result = $this->db->get('matricula');

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