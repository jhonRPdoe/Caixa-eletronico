<?php

namespace App\Controller;

/**
 * Classe base para os controllers.
 * @package Controller
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class Controller {

    private $Model;
    private $Persistencia;
    private $ControllerLog;

    public function getModelController() {
        return $this->Model; 
    }

    public function setModelController($oModel) {
        $this->Model = $oModel;
        $this->Model->buscaDados();
        $this->setPersistenciaController($oModel->getPersistencia());
    }

    public function getPersistenciaController() {
        return $this->Persistencia; 
    }

    public function setPersistenciaController($oPersistencia) {
        $this->Persistencia = $oPersistencia; 
    }

    public function getControllerLog() {
        return $this->ControllerLog; 
    }

    public function setControllerLog($oController) {
        $this->ControllerLog = $oController; 
    }
}