<?php

namespace App\Interface;

/**
 * Interface para o registro de notificações
 * @package Interface
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 19/10/2025
 */
interface InterfaceNotificacao {

    /**
     * Registra um evento do sistema.
     * @param string $sMensagem
     */
    public function registrar(string $sMensagem);
}