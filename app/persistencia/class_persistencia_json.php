<?php

namespace App\Persistencia;

/**
 * Persistencia base para salvar os dados em arquivos JSON.
 * @package Persistencia
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
abstract class PersistenciaJson extends Persistencia {

    /**
     * @var string
     */
    private $caminhoArquivo;

    public function __construct($sArquivoJson) {
        $this->caminhoArquivo = __DIR__ . '/../dados/' . $sArquivoJson;
        if (!file_exists($this->caminhoArquivo)) file_put_contents($this->caminhoArquivo, json_encode([]));
    }

    /**
     * Retorna todos os dados do arquivo JSON
     * @return array
     */
    final protected function getDadosArquivo() {
        $conteudo = file_get_contents($this->caminhoArquivo);
        return json_decode($conteudo, true) ?? [];
    }

    /**
     * Salva os valores informados no arquivo JSON
     * @param array $aDados
     */
    final protected function salvar($aDados) {
        file_put_contents(
            $this->caminhoArquivo,
            json_encode($aDados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * Retorna um array com os registros que atenderem as condições informadas
     * @return array
     */
    public function buscar($aCondicao) {
        $aDadosArquivo = $this->getDadosArquivo();
        $aRetorno = [];
        foreach ($aDadosArquivo as $aRegistro) {
            $match = true;
            foreach ($aCondicao as $sIndex => $sValor) {
                if (!isset($aRegistro[$sIndex]) || $aRegistro[$sIndex] != $sValor) {
                    $match = false;
                    break;
                }
            }
            if ($match) {
                $aRetorno[] = $aRegistro;
            }
        }
        return $aRetorno;
    }

    /**
     * @inheritDoc
     */
    public function inserir() {
        $oModel = $this->getModel();
        $aDados = $this->getDadosArquivo();
        $oModel->setCodigo(count($aDados));
        $aDados[] = $oModel->toArray();
        $this->salvar($aDados);
    }

    /**
     * @inheritDoc
     */
    public function atualizar() {
        $oModel = $this->getModel();
        $aDadosArquivo = $this->getDadosArquivo();
        foreach ($aDadosArquivo as $aRegistro) {
            if ($aRegistro['codigo'] === $oModel->getCodigo()) {
                $aDadosArquivo[array_search($aRegistro, $aDadosArquivo)] = $oModel->toArray();
                break;
            }
        }
        $this->salvar($aDadosArquivo);
    }

    /**
     * @inheritDoc
     */
    public function deletar() {
        $aDadosArquivo = $this->getDadosArquivo();
        $aDadosNovos = array_filter($aDadosArquivo, fn($aRegistro) => $aRegistro['codigo'] != $this->getModel()->getCodigo());
        if (count($aDadosArquivo) === count($aDadosNovos)) {
            return false;
        }
        $this->salvar(array_values($aDadosNovos));
        return true;
    }

    /**
     * @inheritDoc
     */
    public function buscaDadosModel($aCondicao) {
        $bRetorno = false;
        $oModel = $this->getModel();
        $aRegistros = $this->buscar($aCondicao);
        foreach ($aRegistros as $aRegistro) {
            foreach ($aRegistro as $sIndex => $sValor) {
                $sMetodo = 'set' . ucfirst($sIndex);
                if (method_exists($oModel, $sMetodo)) {
                    $oModel->$sMetodo($sValor);
                }
            }
            $bRetorno = true;
        }
        return $bRetorno;
    }
}