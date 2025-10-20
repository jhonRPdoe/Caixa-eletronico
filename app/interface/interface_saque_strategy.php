<?php

namespace App\Interface;

/**
 * Interface para as estratégias de saque
 * @package Interface
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 19/10/2025
 */
interface InterfaceSaqueStrategy {

    /**
     * Calcula a composição de notas para o saque
     * @param int $iValor
     * @param array $aEstoque
     * @return array|null
     */
    public function calcularNotas(int $iValor, array $aEstoque);
}