<?php

namespace App\Model;

use App\Persistencia\Persistencia;

/**
 * Classe base para os modelos de dados.
 * @package Model
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
abstract class Model {

    /**
     * @var integer
     */
    private $codigo;

    /**
     * @var Persistencia
     */
    private $Persistencia;

    /**
     * @param Persistencia $oPersistencia
     */
    public function __construct($oPersistencia) {
        $this->Persistencia = $oPersistencia;
        $this->Persistencia->setModel($this);
    }

    /**
     * Retorna a persistencia do modelo
     * @return Persistencia
     */
    public function getPersistencia() {
        return $this->Persistencia;
    }

    /**
     * Retorna um array com os dados do modelo
     * @return array
     */
    abstract public function toArray();

    /**
     * Persiste as informações do modelo. Retorna false se o registro não existe.
     * @return boolean
     */
    abstract public function buscaDados();

    /**
     * Verifica se o Modelo já existe no banco
     * @return boolean
     */
    public function getExiste() {
        return (bool) count($this->getPersistencia()->buscar(['codigo' => $this->getCodigo()]));
    }

    /**
     * Faz o INSERT do model
     */
    public function inserir() {
        $this->getPersistencia()->inserir();
    }

    /**
     * Faz o UPDATE do model
     */
    public function atualizar() {
        $this->getPersistencia()->atualizar();
    }

    /**
     * Retorna o codigo chave do modelo
     * @return integer
     */
    public function getCodigo() {
        return $this->codigo; 
    }

    /**
     * Define o codigo chave do modelo
     * @param integer $iCodigo
     */
    public function setCodigo($iCodigo) {
        return $this->codigo = $iCodigo; 
    }
}