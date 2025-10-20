<?php

namespace App\Persistencia;

use App\Model\Model;

/**
 * Classe base para as persistencias de dados.
 * @package Persistencia
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
abstract class Persistencia {

    /**
     * @var Model
     */
    protected $Model;

    /**
     * REtorna o modelo da persistencia
     * @return Model
     */
    public function getModel() {
        return $this->Model;
    }

    /**
     * Define o modelo da persistencia
     * @param Model $oModel
     */
    public function setModel($oModel) {
        $this->Model = $oModel;
    }

    /**
     * Busca um registro com base nas condições.
     * @param array $aCondicao
     */
    abstract public function buscar($aCondicao);

    /**
     * Salva o registro.
     */
    abstract public function inserir();

    /**
     * Atualiza o registro.
     */
    abstract public function atualizar();

    /**
     * Remove o registro.
     */
    abstract public function deletar();

    /**
     * Busca os dados do modelo com base nas condições informadas. Retorna false se o registro não existe.
     * @param array $aCondicao
     * @return boolean
     */
    abstract public function buscaDadosModel($aCondicao);
}