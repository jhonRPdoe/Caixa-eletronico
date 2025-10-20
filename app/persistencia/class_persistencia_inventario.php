<?php

namespace App\Persistencia;

/**
 * Persistencia para os dados do caixa eletronico
 * @package Persistencia
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class PersistenciaInventario extends PersistenciaJson {

    public function __construct($oModel = null) {
        parent::__construct('inventario.json');
        if ($oModel) $this->setModel($oModel);
    }
}