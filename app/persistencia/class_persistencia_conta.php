<?php

namespace App\Persistencia;

use App\Model\ModelConta,
    InvalidArgumentException;

/**
 * Persistencia para os dados da conta do usuário
 * @package Persistencia
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class PersistenciaConta extends PersistenciaJson {

    public function __construct($oModel = null) {
        parent::__construct('contas.json');
        if ($oModel) $this->setModel($oModel);
    }

    /**
     * @inheritDoc
     */
    public function setModel($oModel) {
        if (!$oModel instanceof ModelConta) {
            throw new InvalidArgumentException("O modelo deve ser uma instância de ModelConta.");
        }
        parent::setModel($oModel);
    }

    /**
     * Retorna a quantidade de registros salvos
     * @return integer
     */
    public function getQuantidadeRegistros() {
        return count($this->getDadosArquivo());
    }
}