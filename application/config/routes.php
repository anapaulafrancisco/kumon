<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['home'] = 'home/index';

//USUARIO
$route['usuario/gerenciar'] = 'usuario/usuario/index';
$route['usuario/ver/(:any)'] = 'usuario/usuario/ver/$1';
$route['usuario/incluir'] = 'usuario/usuario/formIncluirUsuario';
$route['usuario/editar/(:any)'] = 'usuario/usuario/formEditarUsuario/$1';
$route['usuario/incluir/salvar'] = 'usuario/usuario/incluirUsuario';
$route['usuario/editar/(:any)/salvar'] = 'usuario/usuario/editarUsuario';
$route['usuario/configuracao'] = 'usuario/usuario/config';

//ALUNO
$route['aluno/gerenciar'] = 'aluno/aluno/index';
$route['aluno/ver/(:any)'] = 'aluno/aluno/ver/$1';
$route['aluno/incluir'] = 'aluno/aluno/formIncluirAluno';
$route['aluno/editar/(:any)'] = 'aluno/aluno/formEditarAluno/$1';
$route['aluno/incluir/salvar'] = 'aluno/aluno/incluirAluno';
$route['aluno/editar/(:any)/salvar'] = 'aluno/aluno/editarAluno';

//PESSOA
$route['pessoa/gerenciar'] = 'pessoa/pessoa/index';
$route['pessoa/ver/(:any)'] = 'pessoa/pessoa/ver/$1';
$route['pessoa/incluir'] = 'pessoa/pessoa/formIncluirPessoa';
$route['pessoa/editar/(:any)'] = 'pessoa/pessoa/formEditarPessoa/$1';
$route['pessoa/incluir/salvar'] = 'pessoa/pessoa/incluirPessoa';
$route['pessoa/editar/(:any)/salvar'] = 'pessoa/pessoa/editarPessoa';

//RELATORIO
$route['relatorio/gerenciar'] = 'relatorio/relatorio/index';
$route['relatorio/ver/(:any)'] = 'relatorio/relatorio/ver/$1';

//UNIDADE
$route['unidade/editar'] = 'unidade/unidade/formEditarUnidade';
$route['unidade/editar/(:any)/salvar'] = 'unidade/unidade/editarUnidade';

//MATRICULA
$route['matricula/gerenciar'] = 'matricula/matricula/index';
$route['matricula/ver/(:any)'] = 'matricula/matricula/ver/$1';
$route['matricula/incluir'] = 'matricula/matricula/formIncluirMatricula';
$route['matricula/editar/(:any)'] = 'matricula/matricula/formEditarMatricula/$1';
$route['matricula/incluir/salvar'] = 'matricula/matricula/incluirMatricula';
$route['matricula/editar/(:any)/salvar'] = 'matricula/matricula/editarMatricula';