<?php

namespace App\Controller;

use App\Interface\InterfaceNotificacao;

/**
 * Controller para o registro das notificações do sistema em arquivo
 * @package Controller
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 19/10/2025
 */
class ControllerNotificacaoArquivo implements InterfaceNotificacao {

    /**
     * @var string
     */
    private $caminhoArquivo;

    public function __construct($sNomeArquivo = 'log_caixa.txt') {
        $this->caminhoArquivo = 'C:\xampp\htdocs\caixa-eletronico\log\\' . $sNomeArquivo;
    }

    /**
     * Registra a mensagem e data atual no arquivo de log
     * @param string $sMensagem
     */
    public function registrar(string $sMensagem) {
        date_default_timezone_set('America/Sao_Paulo');
        $sDataHora = date('d-m-Y H:i:s');
        file_put_contents(
            $this->caminhoArquivo,
            "[$sDataHora] $sMensagem" . PHP_EOL,
            FILE_APPEND
        );
    }
}