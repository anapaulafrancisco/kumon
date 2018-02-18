<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacao
{
	protected $ci;

	private static $_tipos = array('erro', 'sucesso', 'info', 'atencao');
    public static $NOTIFICACAO_ERRO = 'erro';
    public static $NOTIFICACAO_INFO = 'info';
    public static $NOTIFICACAO_SUCESSO = 'sucesso';
    public static $NOTIFICACAO_ATENCAO = 'atencao';

	//public function __construct()
	//{
     //   $this->ci =& get_instance();
        //$this->ci =& get_instance();
	//}

	public static function setNotificacao($mensagem = '', $tipo = 'sucesso', $tag = '')
    {
        if (!in_array($tipo, self::$_tipos))
        {
            throw new Exception('Tipo de notificação inválida!');
        }
        else
        {
            $tag = str_replace('_', '', $tag);
            self::_getCI()->session->set_userdata("tipoNotificacao_{$tag}", $tipo);
            self::_getCI()->session->set_userdata("mensagemNotificacao_{$tag}", $mensagem);
        }
    }

    public static function getNotificacao($tag = '')
    {
        $session = self::_getCI()->session;
        if ($session->userdata("mensagemNotificacao_{$tag}"))
        {
            $tag = str_replace('_', '', $tag);
            $mensagem = $session->userdata("mensagemNotificacao_{$tag}");
            list($tipo) = explode('_', $session->userdata("tipoNotificacao_{$tag}"));

            //apaga da session para nao aparecer no proximo request
            $session->unset_userdata("mensagemNotificacao_{$tag}");
            $session->unset_userdata("tipoNotificacao_{$tag}");

            switch ($tipo)
            {
                case self::$NOTIFICACAO_ERRO:
                    $class = 'danger';
                    break;
                case self::$NOTIFICACAO_SUCESSO:
                    $class = 'success';
                    break;
                case self::$NOTIFICACAO_ATENCAO:
                    $class = 'warning';
                    break;
                case self::$NOTIFICACAO_INFO:
                default:
                    $class = 'info';
            }

            $htmlNotificacao = '<div class="alert alert-' . $class . '" id="msg_notificacao' . $tag . '">' . $mensagem . '</div>';


           /* $htmlNotificacao = '<div class="alert alert-' . $class . ' alert-dismissible fade in" role="alert" id="msg_notificacao' . $tag . '">
                    				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    					<span aria-hidden="true">×</span>
                    				</button>
                    				' . $mensagem . '
                  				</div>';*/

            return $htmlNotificacao;
        }
    }

    private static function _getCI()
    {
        return get_instance();
    }

}

/* End of file notificacao.php */
/* Location: ./application/libraries/notificacao.php */
