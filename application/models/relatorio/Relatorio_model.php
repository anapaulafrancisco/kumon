<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }

    /**
     * Funcao responsavel por buscar informacoes sobre o progresso do aluno no curso
     *
     * @param [type] $cursoID
     * @param [type] $alunoID
     * @param [type] $periodo
     * @return void
     */
    public function relFolhaMes($cursoID, $alunoID, $periodo)
    {
        $this->db->query("SET lc_time_names = 'pt_BR'");
        $result = $this->db->query("SELECT
                                        DATE_FORMAT(p.data_cadastro, '%M') AS mes_completo,
                                        DATE_FORMAT(p.data_cadastro, '%b') AS mes,
                                        p.qtde_folhas,
                                        CONCAT(e.nome_estagio, ' - ', p.qtde_folhas) AS info_estagio,
                                        YEAR(p.data_cadastro) AS ano,
                                        a.nome_aluno,
                                        m.serie,
                                        m.periodo
                                    FROM
                                        progresso_estudo p
                                        JOIN estagio e ON (e.id_estagio = p.id_estagio)
                                        JOIN aluno a ON (a.id_aluno = p.id_aluno)
                                        JOIN matricula m ON (m.id_aluno = a.id_aluno)
                                    WHERE
                                        p.id_curso = {$cursoID}
                                    AND
                                        p.id_aluno = {$alunoID} 
                                    AND
                                        p.data_cadastro >= '{$periodo}' ");

		if (is_object($result) && $result->num_rows() > 0)
        {
           return array('resp' => 'ok', 'info' => $result->result_array());
        }
        else
        {
            return array('resp' => 'erro');
        }	
    }
    
}