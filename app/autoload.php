<?php

/**
 * Arquivo para o carregamento automático dos arquivos pelo namespace
 */
spl_autoload_register(function ($classe) {
    $sPrefixoArquivo = 'App\\';
    $sBaseDir = __DIR__ . '/';
    if (strncmp($sPrefixoArquivo, $classe, strlen($sPrefixoArquivo)) !== 0) return;
    $aPartes = explode('\\', substr($classe, strlen($sPrefixoArquivo)));
    $aPartes = array_map(function($sParte) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $sParte));
    }, $aPartes);
    $sPrefixoArquivo = ($aPartes[0] != 'interface') ? '/class_' : '/';
    $arquivo = $sBaseDir . array_shift($aPartes) . $sPrefixoArquivo . implode('_', $aPartes) . '.php';
    if (file_exists($arquivo)) require_once $arquivo;
});