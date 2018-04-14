<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serie_model extends CI_Model {

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
    public function listarSerie()
    {
        $result = $this->db->get('serie');

		if (is_object($result) && $result->num_rows() > 0)
        {
            $arrResult = $result->result_array();
  
            $arrInfoSerie = array();

            foreach($arrResult as $serie)
            {
                $arrInfoSerie[$serie['nivel']][$serie['id_serie']] = $serie['nome_serie'];
            }
    
            return $arrInfoSerie;    
        }
        else
        {
            return array();
        }
    }
    
}