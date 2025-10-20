<?php

namespace App\Controller;

use App\Model\ModelConta,
    App\Model\ModelInventario,
    App\Strategy\StrategySaqueMenorQuantidade,
    App\Strategy\StrategySaquePreservarNotasGrandes;

/**
 * Controller para as operações de inventário
 * @package Controller
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class ControllerInventario extends Controller {

    public function __construct() {
        session_start();
        if (!isset($_SESSION['codigoConta'])) {
            header('Location: index.php');
            exit;
        }
        $this->setModelController($this->getModelInventario());
        $this->setControllerLog(new ControllerNotificacaoArquivo());
    }

    /**
     * Executa o processamento necessário para efetuar o saque
     */
    public function sacar() {
        $oControllerLog = $this->getControllerLog();
        list($aNotas, $iValorSolicitado) = $this->getDadosTelaTratados();

        if ($this->getModelConta()->getPodeSacar($iValorSolicitado)) {
            $oControllerLog->registrar("Início do saque de R$ $iValorSolicitado pela conta de código: " . $this->getModelConta()->getCodigo());
            if ($aNotasSaque = $this->getModelInventario()->sacar($iValorSolicitado, new StrategySaqueMenorQuantidade())) {
                $oControllerLog->registrar("Saque realizado com sucesso. Estratégia usada: StrategySaqueMenorQuantidade | Valor: R$ $iValorSolicitado pela conta de código: " . $this->getModelConta()->getCodigo());
            } else {
                $oControllerLog->registrar('Falha com StrategySaqueMenorQuantidade, tentando preservar notas grandes...');
                $aNotasSaque = $this->getModelInventario()->sacar($iValorSolicitado, new StrategySaquePreservarNotasGrandes());
                if ($aNotasSaque) $oControllerLog->registrar("Saque realizado com sucesso. Estratégia usada: StrategySaquePreservarNotasGrandes | Valor: R$ $iValorSolicitado pela conta de código: " . $this->getModelConta()->getCodigo());
            }
            if ($aNotasSaque) {
                $oControllerLog->registrar('Foram utilizadas as seguintes notas: ' . json_encode($aNotas));
                $this->getModelInventario()->descarregar($aNotasSaque);
                $this->getModelConta()->descarregar($iValorSolicitado);
                $this->getModelInventario()->atualizar();
                $this->getModelConta()->atualizar();
                $this->exibirTelaSucesso();
            } else {
                $sSugestoesSaque = implode(', R$ ', $this->getModelInventario()->getSugestaoSaque($iValorSolicitado, new StrategySaqueMenorQuantidade()));
                $oControllerLog->registrar("Falha com StrategySaquePreservarNotasGrandes. Não foi possível realizar o saque de R$ $iValorSolicitado com as notas disponíveis no caixa.");
                $this->exibirTelaSaque("Não foi possível realizar o saque de R$ $iValorSolicitado com as notas disponíveis no caixa. Você pode sacar: R$ $sSugestoesSaque");
            }
        } else {
            $oControllerLog->registrar('Saque falhou. A conta de código: ' . $this->getModelConta()->getCodigo() . ' Não possui saldo suficiente.');
            $this->exibirTelaSaque('Você não possui saldo suficiente para este saque.');
        }
    }

    /**
     * Executa o processamento necessário para efetuar o depósito
     */
    public function depositar() {
        $oControllerLog = $this->getControllerLog();
        list($aNotas, $iValorDepositado) = $this->getDadosTelaTratados();
    
        $oControllerLog->registrar('Início do deposito de R$ ' . $iValorDepositado . ' pela conta de código: ' . $this->getModelConta()->getCodigo());
        $this->getModelInventario()->carregar($aNotas);
        ($this->getModelInventario()->getExiste()) ? $this->getModelInventario()->atualizar() : $this->getModelInventario()->inserir();
        $this->getModelConta()->carregar($iValorDepositado);
        $this->getModelConta()->atualizar();
        $oControllerLog->registrar('Deposito realizado com sucesso. Valor: R$ ' . $iValorDepositado . ' pela conta de código: ' . $this->getModelConta()->getCodigo());
        $oControllerLog->registrar('Foram utilizadas as seguintes notas: ' . json_encode($aNotas));
        $this->exibirTelaSucesso();
    }

    /**
     * Retorna o ModelConta do usuário logado
     * @return ModelConta
     */
    public function getModelConta() {
        static $oConta;
        if (!isset($oConta)) {
            $oConta = new ModelConta();
            $oConta->setCodigo($_SESSION['codigoConta']);
            $oConta->buscaDados();
        }
        return $oConta;
    }

    /**
     * Retorna o ModelInventario do inventário ativo no momento
     * @return ModelInventario
     */
    public function getModelInventario() {
        static $oInventario;
        if (!isset($oInventario)) {
            $oInventario = new ModelInventario();
            $oInventario->setCodigo(0);
            $oInventario->buscaDados();
        }
        return $oInventario;
    }

    /**
     * Retorna os dados da tela tratados para a inserção no model
     * @return array
     */
    private function getDadosTelaTratados() {
        $aDadosTela = $_POST;
        $aNotas = [];
        $sValorTotal = array_shift($aDadosTela);
        $sValorTotal = substr(str_replace(['R$', '.'], ['', ''], $sValorTotal), 2);
        $iValor = (float) str_replace(',', '.', $sValorTotal);
        foreach ($aDadosTela as $sIndex => $iQuantidade) {
            if (!$iQuantidade) $iQuantidade = 0;
            $aNotas[str_replace('quantidade-nota', '', $sIndex)] = $iQuantidade;
        }
        return [$aNotas, $iValor];
    }

    /**
     * Exibe a view de operação bem sucedida
     * @param string $sErro
     * @param string $sMensagem
     */
    public function exibirTelaSucesso($sErro = null, $sMensagem = null) {
        include __DIR__ . '/../../view/view_operacao_sucesso.php';
    }

    /**
     * Exibe a view de saque
     * @param string $sErro
     * @param string $sMensagem
     */
    public function exibirTelaSaque($sErro = null, $sMensagem = null) {
        include __DIR__ . '/../../view/view_saque.php';
    }
}