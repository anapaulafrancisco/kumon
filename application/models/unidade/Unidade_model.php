<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidade_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }

    public function buscarUnidade()
	{
        $this->db->join('pessoa p', 'p.id_pessoa = u.id_pessoa');
        $this->db->select(" u.*, 
                            TIME_FORMAT(u.horario_inicio, '%h:%m') as horario_inicio_formatado,
                            TIME_FORMAT(u.horario_fim, '%H:%m') as horario_fim_formatado, 
                            p.nome_pessoa ");
        $result = $this->db->get('unidade u');

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
	 * Funcao responsavel por editar a unidade
	 * 
	 * @param type $arrInfoPessoa 
	 * @param type $idPessoaDescrip 
	 * @return type
	 */
	public function editarUnidade($arrInfoUnidade, $idUnidadeDescrip)
	{
		$this->db->where('id_unidade', $idUnidadeDescrip);
		$this->db->update('unidade', $arrInfoUnidade);
	}
}