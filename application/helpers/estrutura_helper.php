<?php 

//carrega view topo
if ( !function_exists('getTopo') )
{
	function getTopo()
	{
		$ci = get_instance();
	    $ci->load->view('estrutura/topo');
	}   
}

//-----------------------------------------------------------

//carrega view cabecalho
if ( !function_exists('getCabecalho') )
{
	function getCabecalho()
	{
	    $ci = get_instance();
	    $ci->load->view('estrutura/cabecalho');
	}
}

//-----------------------------------------------------------

//carrega view rodape
if ( !function_exists('getRodape') )
{
	function getRodape()
	{
	    $ci = get_instance();
	    $ci->load->view('estrutura/rodape');
	}
}

//-----------------------------------------------------------

//carrega view menu
if ( !function_exists('getMenu') )
{
	function getMenu()
	{
		$ci = get_instance();
	    $ci->load->view('estrutura/menu');
		//require_once(APPPATH."views/estrutura/menu.php");
	}
}

//-----------------------------------------------------------

/**
 * Funcao responsavel por buscar as categorias
 */
if ( !function_exists('getSubMenuCategorias') )
{
	function getSubMenuCategorias()
	{
		$ci = get_instance();
		$ci->load->model('categoria/categoria_model');
		$arrCategorias = $ci->categoria_model->listarCategoria(1);

		return $arrCategorias;
	}
}

//-----------------------------------------------------------

/**
 * Funcao responsavel por buscar os relatorios
 */

if ( !function_exists('getSubMenuRelatorios') )
{
	function getSubMenuRelatorios()
	{
		$ci = get_instance();
		$ci->load->model('relatorio/relatorio_model');
		$arrCredencial = get_credencial();
		$arrRelatorios = $ci->relatorio_model->listarRelatorioMenu($arrCredencial['id_usuario']);

		return $arrRelatorios;
	}
}