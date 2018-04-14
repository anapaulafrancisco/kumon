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
     * @param [type] $idCurso
     * @param [type] $idAluno
     * @param [type] $periodo
     * @return void
     */
    public function relFolhaMes($idCurso, $idAluno, $periodo)
    {
        $this->db->query("SET lc_time_names = 'pt_BR'");
 
        $result = $this->db->query("SELECT
                                        DATE_FORMAT(p.data_cadastro, '%M') AS mes_completo,
                                        DATE_FORMAT(p.data_cadastro, '%b') AS mes,	
                                        YEAR(p.data_cadastro) AS ano,
                                        p.qtde_folhas,
                                        CONCAT(e.nome_estagio, ' - ', p.qtde_folhas) AS info_estagio,
                                        s.nivel,
                                        s.id_serie,
                                        s.nome_serie,
                                        (SELECT
                                            pr.classificacao
                                        FROM
                                            serie_premiacao sp
                                            JOIN premiacao pr ON (pr.id_premiacao = sp.id_premiacao)        
                                        WHERE
                                            sp.id_curso = {$idCurso}
                                        AND
                                            sp.id_serie = s.id_serie
                                        AND
                                            sp.estagio_folhas = CONCAT(e.nome_estagio, ' - ', p.qtde_folhas)
                                        ) AS premiacao,
                                        (SELECT
                                            sp.sequencia_premiacao
                                        FROM
                                            serie_premiacao sp
                                            JOIN premiacao pr ON (pr.id_premiacao = sp.id_premiacao)        
                                        WHERE
                                            sp.id_curso = {$idCurso}
                                        AND
                                            sp.id_serie = s.id_serie
                                        AND
                                            sp.estagio_folhas = CONCAT(e.nome_estagio, ' - ', p.qtde_folhas)
                                        ) AS sequencia_premiacao
                                    FROM
                                        progresso_estudo p
                                        JOIN estagio e ON (e.id_estagio = p.id_estagio)
                                        JOIN aluno a ON (a.id_aluno = p.id_aluno)
                                        JOIN serie s ON (s.id_serie = a.id_serie)
                                    WHERE
                                        p.id_aluno = {$idAluno}
                                    AND 
                                        e.id_curso = {$idCurso} 
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

    //-----------------------------------------------------------

    /**
     * Funcao responsavel por buscar a premiacao almejada pelo aluno
     *
     * @param [type] $idCurso
     * @param [type] $idSerie
     * @param [type] $sequenciaPremiacao
     * @return void
     */
    function buscaPremiacaoAlmejada($idCurso, $idSerie, $sequenciaPremiacao)
    {
        $result = $this->db->query("SELECT
                                        sp.estagio_folhas,
                                        pr.classificacao
                                    FROM
                                        serie_premiacao sp
                                        JOIN premiacao pr ON (pr.id_premiacao = sp.id_premiacao)        
                                    WHERE
                                        sp.id_curso = {$idCurso}
                                    AND
                                        sp.id_serie = {$idSerie}
                                    AND
                                        sp.sequencia_premiacao = {$sequenciaPremiacao} ");

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