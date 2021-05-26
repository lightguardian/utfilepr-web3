<?php
namespace Teste\Funcional;

use \Teste\Teste;
use \Modelo\Arquivo;
use \Modelo\Usuario;
use \Framework\DW3BancoDeDados;

class TesteArquivos extends Teste
{
    public function testeListagemDeslogado()
    {
        $resposta = $this->get(URL_RAIZ . 'arquivos');
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeListagem()
    {
        $this->logar();
        (new Arquivo($this->usuario->getId(), 'teste.txt', 'Texto para teste testando a testa têxtil que esta tastaviando!' ,'hash_code', '2021-05-23'))->salvar();
        $resposta = $this->get(URL_RAIZ . 'arquivos');
        
        $this->verificarContem($resposta, 'teste.txt');
        $this->verificarContem($resposta, 'Texto para teste testando a testa têxtil que esta tastaviando!');
        $this->verificarContem($resposta, '23-05-2021');
    }

    public function testeArmazenarDeslogado()
    {
        $resposta = $this->post(URL_RAIZ . 'arquivos', [
            'nome' => 'teste.txt'
        ]);
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeArmazenar()
    {
        // $this->logar();
        // $resposta = $this->post(URL_RAIZ . 'arquivos', [
        //     'arquivo' => null,
        //     'descricao' => 'arquivo de texto comum'
        // ]);

        // die;
        // $this->verificarRedirecionar($resposta, URL_RAIZ . 'arquivos');
        // $query = DW3BancoDeDados::query('SELECT * FROM arquivos');
        // $bdArquivos = $query->fetchAll();
        // $this->verificar(count($bdArquivos) == 1);
    }

    // public function testeDestruir()
    // {
    //     $this->logar();
    //     $mensagem = new Mensagem($this->usuario->getId(), 'Olá');
    //     $mensagem->salvar();
    //     $resposta = $this->delete(URL_RAIZ . 'mensagens/' . $mensagem->getId());
    //     $this->verificarRedirecionar($resposta, URL_RAIZ . 'mensagens');
    //     $query = DW3BancoDeDados::query('SELECT * FROM mensagens');
    //     $bdReclamacao = $query->fetch();
    //     $this->verificar($bdReclamacao === false);
    // }

    // public function testeDestruirDeOutroUsuario()
    // {
    //     $this->logar();
    //     $outroUsuario = new Usuario('teste2@teste2.com', '123');
    //     $outroUsuario->salvar();
    //     $mensagem = new Mensagem($outroUsuario->getId(), 'Olá');
    //     $mensagem->salvar();
    //     $resposta = $this->delete(URL_RAIZ . 'mensagens/' . $mensagem->getId());
    //     $this->verificarRedirecionar($resposta, URL_RAIZ . 'mensagens');
    //     $query = DW3BancoDeDados::query('SELECT * FROM mensagens');
    //     $bdReclamacao = $query->fetch();
    //     $this->verificar($bdReclamacao !== false);
    // }
}
