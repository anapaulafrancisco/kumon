<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por buscar usuario no sistema para fazer a autenticacao
	 * 
	 * @param type $usuario 
	 * @return array
	 */
	public function buscaUsuario($usuario)
	{
		$result = $this->db->query("SELECT
										u.*,
										GROUP_CONCAT(DISTINCT p.id_perfil SEPARATOR ',') AS perfis,
										GROUP_CONCAT(DISTINCT p.perfil SEPARATOR ',') AS perfis_nomes
									FROM 
										usuario u
										JOIN usuario_perfil up ON (up.id_usuario = u.id_usuario)
										JOIN perfil p ON (p.id_perfil = up.id_perfil)
									WHERE
										u.usuario = '{$usuario}'
									AND
										u.ativo = 1			
									GROUP BY
									 	u.id_usuario");

		if (is_object($result) && $result->num_rows() > 0)
        {
            return $result->row_array();
        }
        else
        {
            return array();
        }
	}

	/* public function atualizarSenha($arrInfoUsuario, $idUsuario)
	{
		$this->db->where('id_usuario', $idUsuario);
		$this->db->update('usuario', $arrInfoUsuario);
	} */
}

