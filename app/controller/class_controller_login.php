<?php

namespace App\Controller;

use App\Model\ModelConta;

/**
 * Controller para as funções da tela de login
 * @package Controller
 * @author Ruan Pereira -> ruanpdev@outlook.com
 * @since 18/10/2025
 */
class ControllerLogin extends Controller {

    public function __construct() {
        $this->setControllerLog(new ControllerNotificacaoArquivo());
    }

    /**
     * Exibe a view de login/cadastro
     * @param string $sErro
     * @param string $sMensagem
     */
    public function exibirTelaLogin($sErro = null, $sMensagem = null) {
        include __DIR__ . '/../../view/view_login.php';
    }

    /**
     * Executa o processo necessário para efetuar o login na conta do usuário
     */
    public function logar() {
        $oControllerLog = $this->getControllerLog();
        $sCpf = $_POST['cpf'];
        $sSenha = $_POST['senha'];

        $oControllerLog->registrar("Iníciando login com o CPF: $sCpf");
        if ($this->validarCpf($sCpf)) {
            $oConta = new ModelConta();
            $aConta = $oConta->getPersistencia()->buscar([
                'cpf' => $sCpf
            ]);

            if (!empty($aConta) && password_verify($sSenha, $aConta[0]['senha'])) {
                session_start();
                $_SESSION['codigoConta'] = $aConta[0]['codigo'];
                $_SESSION['saldoConta'] = $aConta[0]['saldo'];
                $oControllerLog->registrar('Login efetuado com sucesso.');
                header('Location: index.php?acao=menu');
                exit;
            } else {
                $oControllerLog->registrar('CPF ou senha incorretos.');
                $this->exibirTelaLogin('CPF ou senha incorretos.');
            }
        } else {
            $oControllerLog->registrar('CPF inválido.');
            $this->exibirTelaLogin('CPF inválido.');
        }
    }

    /**
     * Executa o processo necessário para efetuar o cadastro de conta
     */
    public function cadastrar() {
        $oControllerLog = $this->getControllerLog();
        $sNome = $_POST['nome'];
        $sCpf = $_POST['cpf'];
        $sSenha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $oControllerLog->registrar("Iníciando cadastro com o CPF: $sCpf");
        if ($this->validarCpf($sCpf)) {
            $oConta = new ModelConta();
            $existe = $oConta->getPersistencia()->buscar(['cpf' => $sCpf]);

            if (!empty($existe)) {
                $oControllerLog->registrar('Já existe uma conta com este CPF.');
                $this->exibirTelaLogin('Já existe uma conta com este CPF.');
            } else {
                $oConta->setNome($sNome);
                $oConta->setCpf($sCpf);
                $oConta->setSenha($sSenha);
                $oConta->setSaldo(0.0);
                $oConta->inserir();

                $oControllerLog->registrar('Conta criada com sucesso.');
                $this->exibirTelaLogin(null, 'Conta criada com sucesso!');
            }
        } else {
            $oControllerLog->registrar('CPF inválido.');
            $this->exibirTelaLogin('CPF inválido.');
        }
    }
    /**
     * Valida um CPF
     * @param string $sCpf
     * @return boolean
     */
    private function validarCpf(string $sCpf) {
        $sCpf = preg_replace('/\D/', '', $sCpf);
        if (strlen($sCpf) != 11) return false;
        if (preg_match('/^(\d)\1{10}$/', $sCpf)) return false;

        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += intval($sCpf[$i]) * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += intval($sCpf[$i]) * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        return $sCpf[9] == $digito1 && $sCpf[10] == $digito2;
    }
}