<?php

/**
 * Verifica se o usuario esta logado no sistema
 * @return bool
 */
function is_logado()
{
	$ci = get_instance();
    return $ci->session->has_userdata('credencial');
}

/**
 * Verifica se o usuario tem permissão para executar alguma tarefa
 *
 * @param int $id ID da ação que o usuário pretende executar
 * @return boolean
 */
function has_permissao($id)
{
    $credencial = get_credencial();
    //return in_array($id, $credencial->get_permissoes());
}

/**
 * Retorna a credencial do usuario
 * @return array
 */
function get_credencial()
{
    $ci = get_instance();

    if($ci->session->has_userdata('credencial'))
    {
    	return $ci->session->userdata('credencial');
    }
    else
    {
    	return array();
    }
}

function somente_manager()
{
    $arrCredencial = get_credencial();
    $arrPerfis = explode(',', $arrCredencial['perfis_nomes']);
    $qtdePerfil = count($arrPerfis);
    
    if($qtdePerfil == 1 && $arrPerfis[0] == 'manager')
    {
        return 1;
    }
    else
    {
        return 0;
    }    
}