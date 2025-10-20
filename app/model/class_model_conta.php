<?php

namespace App\Model;

use App\Persistencia\PersistenciaConta;

/**
 * Modelo para os dados da conta do usuário
 * @package Model
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class ModelConta extends Model {

    private string $nome;
    private string $cpf;
    private string $senha;
    private float $saldo;

    public function __construct() {
        parent::__construct(new PersistenciaConta($this));
    }

    /**
     * @return string
     */
    public function getNome() {
        return $this->nome; 
    }

    /**
     * @param string $sNome
     */
    public function setNome($sNome) {
        $this->nome = $sNome; 
    }

    /**
     * @return string
     */
    public function getCpf() {
        return $this->cpf; 
    }

    /**
     * @param string $sCpf
     */
    public function setCpf($sCpf) {
        $this->cpf = $sCpf; 
    }

    /**
     * @return string
     */
    public function getSenha() {
        return $this->senha; 
    }

    /**
     * @param string $sSenha
     */
    public function setSenha($sSenha) {
        $this->senha = $sSenha; 
    }

    /**
     * @return float
     */
    public function getSaldo() { 
        return $this->saldo; 
    }


    /**
     * @param float $iValor
     */
    public function setSaldo($iValor) { 
        $this->saldo = $iValor; 
    }

    /**
     * @inheritDoc
     */
    public function toArray() {
        return [
            'codigo' => $this->getCodigo(),
            'nome' => $this->getNome(),
            'cpf' => $this->getCpf(),
            'senha' => $this->getSenha(),
            'saldo' => $this->getSaldo(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function buscaDados() {
        $this->getPersistencia()->buscaDadosModel(['codigo' => $this->getCodigo()]);
    }

    /**
     * Adiciona valor ao saldo da conta
     * @param float $iValor
     */
    public function carregar($iValor) {
        $this->saldo = $this->saldo + $iValor;
    }

    /**
     * Remove valor ao saldo da conta
     * @param float $iValor
     */
    public function descarregar($iValor) {
        $this->saldo = $this->saldo - $iValor;
    }

    /**
     * Verifica se existe saldo suficiente para o saque na conta
     * @param integer $iValor
     * @return boolean
     */
    public function getPodeSacar(int $iValor) {
        return ($iValor <= $this->getSaldo());
    }
}