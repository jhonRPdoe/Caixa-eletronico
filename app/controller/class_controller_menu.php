<?php

namespace App\Controller;

use App\Model\ModelConta;

/**
 * Controller para as funções da tela de menu
 * @package Controller
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class ControllerMenu extends Controller {

    public function __construct() {
        session_start();
        if (!isset($_SESSION['codigoConta'])) {
            header('Location: index.php');
            exit;
        }
        $oModel = new ModelConta();
        $oModel->setCodigo($_SESSION['codigoConta']);
        $this->setModelController($oModel);
        $this->setControllerLog(new ControllerNotificacaoArquivo());
    }

    /**
     * Exibe a view de menu
     * @param string $sErro
     * @param string $sMensagem
     */
    public function exibirMenu($sErro = null, $sMensagem = null) {
        $sNomeUsuario = $this->getModelController()->getNome();
        $iSaldoConta = $this->getModelController()->getSaldo();
        include __DIR__ . '/../../view/view_menu.php';
    }

    /**
     * Executa o logout da conta
     */
    public function logout() {
        $oControllerLog = $this->getControllerLog();
        session_destroy();
        $oControllerLog->registrar('Logout efetuado com sucesso.');
        header('Location: index.php');
        exit;
    }

    /**
     * Abre a tela de saque
     */
    public function AbrirTelaSaque() {
        include __DIR__ . '/../../view/view_saque.php';
    }

    /**
     * Abre a tela de depósito
     */
    public function AbrirTelaDeposito() {
        include __DIR__ . '/../../view/view_deposito.php';
    }
}