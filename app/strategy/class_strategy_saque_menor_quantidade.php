<?php

namespace App\Strategy;

use App\Interface\InterfaceSaqueStrategy;

/**
 * Estrategia para o saque com a menor quantidade de cédulas
 * @package Strategy
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 19/10/2025
 */
class StrategySaqueMenorQuantidade implements InterfaceSaqueStrategy {

    /**
     * @inheritDoc
     */
    public function calcularNotas(int $iValor, array $aEstoque) {
        $aResultado = [];
        $iResto = $iValor;

        krsort($aEstoque);
        foreach ($aEstoque as $sNota => $iQuantidade) {
            if ($iResto <= 0) break;
            $iUsar = min(intval($iResto / $sNota), $iQuantidade);
            if ($iUsar > 0) {
                $aResultado[$sNota] = $iUsar;
                $iResto -= ($sNota * $iUsar);
            }
        }
        return $iResto === 0 ? $aResultado : null;
    }
}