<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

    	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar todos os usuarios
	 * 
	 * @return array()
	 */
	public function listarUsuario($idUsuario)
	{
		$where = "WHERE	u.id_usuario NOT IN (1, 2)";

		if($idUsuario == 1 || $idUsuario == 2) //IMPLEMENTADOR e ORIENTADOR
		{
			$where = '';
		}

		$result = $this->db->query("SELECT
										u.*,
										GROUP_CONCAT(DISTINCT p.id_perfil SEPARATOR ',') AS perfis_ids,
										GROUP_CONCAT(DISTINCT p.perfil SEPARATOR ', ') AS perfis,
										DATE_FORMAT(u.data_cadastro,'%d/%m/%Y') AS data_cadastro_formatada													FROM 
										usuario u
										JOIN usuario_perfil up ON (up.id_usuario = u.id_usuario)
										JOIN perfil p ON (p.id_perfil = up.id_perfil)
									{$where}
                                    GROUP BY
									 	u.id_usuario
									ORDER BY
									 	u.nome_usuario");	
	
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
	 * Funcao responsavel por buscar todos os perfis
	 * 
	 * @param type|int $ativo 
	 * @return array()
	 */
	public function listarPerfil($ativo = '')
	{
		$this->db->order_by("perfil", "asc");

		if(!empty($ativo))
		{
			$this->db->where('ativo', $ativo);
		}

		$result = $this->db->get('perfil');

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
	 * Funcao responsavel por incluir um usuario
	 * 
	 * @param int $arrInfoUsuario
	 */
	public function incluirUsuario($arrInfoUsuario)
	{
		$this->db->insert('usuario', $arrInfoUsuario);
		return $this->db->insert_id();
	}
}