<?php

namespace App\Model;

use App\Interface\InterfaceSaqueStrategy,
    App\Persistencia\PersistenciaInventario;

/**
 * Modelo para os dados do caixa eletronico
 * @package Model
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class ModelInventario extends Model {

    private $estoque = [1 => 0,
                        2 => 0,
                        5 => 0,
                        10 => 0,
                        20 => 0,
                        50 => 0,
                        100 => 0,
                        200 => 0
                        ];
    private $valorTotal;

    public function __construct() {
        parent::__construct(new PersistenciaInventario($this));
    }

    /**
     * Retorna um array com as notas e suas quatidades
     * @return array
     */
    public function getEstoque() {
        return $this->estoque; 
    }

    /**
     * Define as notas e suas quatidades
     * @param array $aEstoque
     */
    public function setEstoque($aEstoque) {
        $this->estoque = $aEstoque; 
    }

    /**
     * Retorna o valor total disponível no inventário do caixa
     * @return float
     */
    public function getValorTotal() {
        return $this->valorTotal; 
    }

    /**
     * Define o valor total disponível no inventário do caixa
     * @param float $iValorTotal
     */
    public function setValorTotal($iValorTotal) {
        $this->valorTotal = $iValorTotal; 
    }

    /**
     * Adiciona valores ao estoque de notas e ao valor total
     * @param array $aNotas
     * @param float $iValor
     */
    public function carregar(array $aNotas) {
        $this->buscaDados();
        foreach ($aNotas as $iNota => $iQuantidade) {
            $this->estoque[$iNota] += $iQuantidade;
            $this->valorTotal += ($iNota * $iQuantidade);
        }
    }

    /**
     * Remove valores do estoque de notas e do valor total
     * @param array $aNotas
     * @return float
     */
    public function descarregar(array $aNotas) {
        $this->buscaDados();
        foreach ($aNotas as $iNota => $iQuantidade) {
            $this->estoque[$iNota] -= $iQuantidade;
            $this->valorTotal -= ($iNota * $iQuantidade);
        }
    }

    /**
     * Executa o saque de acordo com o valor e estratégia informada
     * @param int $iValor
     */
    public function sacar(int $iValor, InterfaceSaqueStrategy $oStrategy) {
        return $oStrategy->calcularNotas($iValor, $this->getEstoque());
    }

    /**
     * Verifica os valores possíveis para saque de acordo com as notas disponíveis no inventário
     * @param int $iValorSolicitado
     * @param InterfaceSaqueStrategy $oStrategy
     * @param int $iQuantidadeSugestoes
     * @return array
     */
    public function getSugestaoSaque(int $iValorSolicitado, InterfaceSaqueStrategy $oStrategy, $iQuantidadeSugestoes = 3) {
        $aSugestoes = [];
        $iValorPossivel = $iValorSolicitado;
        for ($iValorPossivel; $iValorPossivel > 0; $iValorPossivel--) { 
            $aNotasSaque = $oStrategy->calcularNotas($iValorPossivel, $this->getEstoque());
            if ($aNotasSaque) $aSugestoes[] = $iValorPossivel;
            if (count($aSugestoes) == $iQuantidadeSugestoes) break;
        }
        return $aSugestoes;
    }

    /**
     * @inheritDoc
     */
    public function toArray() {
        return [
            'codigo' => $this->getCodigo(),
            'valorTotal' => $this->getValorTotal(),
            'estoque' => $this->getEstoque(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function buscaDados() {
        return $this->getPersistencia()->buscaDadosModel(['codigo' => $this->getCodigo()]);
    }
}