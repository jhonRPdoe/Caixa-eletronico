    /**
     * Executado a clicar nos componentes de notas
     * @param {string} $sNota 
     */
    function onClickNota($sNota) {
        var oCampoValorTotal = document.querySelector('input[name="valorTotal"]'),
            iValorTotalNumerico = parseFloat(oCampoValorTotal.value.replace("R$", "").trim().replace(".", "").replace(",", "."));

        document.getElementsByName('quantidade-nota' + $sNota)[0].value++;
        oCampoValorTotal.value = Intl.NumberFormat('pt-BR', {
                                                                style: 'currency',
                                                                currency: 'BRL'
                                                            }).format(((isNaN(iValorTotalNumerico) ? $sNota : iValorTotalNumerico + $sNota)));
                                                            
    }

    /**
     * Limpa todos os campos da tela
     */
    function limpaCampos() {
        var aCampos = document.querySelectorAll('.campo');
        for (let i = 0; i < aCampos.length; i++) {
            aCampos[i].value = '';
        }
    }