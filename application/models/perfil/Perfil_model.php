<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Funcao responsavel por incluir perfil do usuario
	 * 
	 * @param int $arrInfoConta
	 */
	public function incluirPerfil($arrInfoPerfil)
	{
		$this->db->insert('usuario_perfil', $arrInfoPerfil);
	}

	//-----------------------------------------------------------

	/**
	 * Funcao responsavel por excluir os perfis cadastrados para o usuario
     * 
	 * @param type $idUsuarioDescrip 
	 * @return type
	 */
	public function excluirPerfil($idUsuarioDescrip)
	{
		$this->db->delete('usuario_perfil', array('id_usuario' => $idUsuarioDescrip));
	}
}