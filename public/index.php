<?php
require_once '../app/autoload.php';

use App\Controller\ControllerInventario,
    App\Controller\ControllerLogin,
    App\Controller\ControllerMenu;

$acao = $_GET['acao'] ?? '';
switch ($acao) {
    case 'logar':
        (new ControllerLogin())->logar();
        break;
    case 'cadastrar':
        (new ControllerLogin())->cadastrar();
        break;
    case 'menu':
        (new ControllerMenu())->exibirMenu();
        break;
    case 'saque':
        (new ControllerMenu())->AbrirTelaSaque();
        break;
    case 'deposito':
        (new ControllerMenu())->AbrirTelaDeposito();
        break;
    case 'sacar':
        (new ControllerInventario())->sacar();
        break;
    case 'depositar':
        (new ControllerInventario())->depositar();
        break;
    case 'logout':
        (new ControllerMenu())->logout();
        break;
    default:
        (new ControllerLogin())->exibirTelaLogin();
        break;
}