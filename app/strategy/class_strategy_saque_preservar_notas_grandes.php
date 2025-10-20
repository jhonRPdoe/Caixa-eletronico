<?php

namespace App\Strategy;

use App\Interface\InterfaceSaqueStrategy;

/**
 * Estrategia para o saque preservar cédulas grandes, usando mais cédulas pequenas
 * @package Strategy
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 19/10/2025
 */
class StrategySaquePreservarNotasGrandes implements InterfaceSaqueStrategy {

    /**
     * @inheritDoc
     */
    public function calcularNotas(int $iValor, array $aEstoque) {
        $aResultado = [];
        $iResto = $iValor;

        ksort($aEstoque);
        foreach ($aEstoque as $sNota => $iQuantidade) {
            if ($iResto <= 0) break;
            $iUsar = min(intval($iResto / $sNota), $iQuantidade);
            if ($iUsar > 0) {
                $aResultado[$sNota] = $iUsar;
                $iResto -= $sNota * $iUsar;
            }
        }
        return $iResto === 0 ? $aResultado : null;
    }
}