<?php
namespace Teste\Unitario;

use \Teste\Teste;
use \Modelo\Usuario;
use \Modelo\Arquivo;
use \Framework\DW3BancoDeDados;

class TesteArquivo extends Teste
{
    private $usuarioId;

    public function antes()
    {
        $usuario = new Usuario('email-teste', 'senha','nome-teste');
        $usuario->salvar();
        $this->usuarioId = $usuario->getId();
    }

    public function testeInserir()
    {
        $arquivo = new Arquivo($this->usuarioId, 'texto.txt', 'apenas um arquivo comum de texto', '[hash-code]', '2021-05-24');
        $arquivo->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM arquivos WHERE id = " . $arquivo->getId());
        $bdArquivo = $query->fetch();
        $this->verificar($bdArquivo['nome'] === $arquivo->getNome());
    }

    public function testeBuscarTodos()
    {
        (new Arquivo($this->usuarioId, 'texto1.txt', 'apenas um arquivo comum de texto1', '[hash-code]', '2021-05-24'))->salvar();
        (new Arquivo($this->usuarioId, 'texto2.txt', 'apenas um arquivo comum de texto2', '[hash-code]', '2021-05-24'))->salvar();
        $arquivos = Arquivo::buscarTodos();
        $this->verificar(count($arquivos) == 2);
    }

    public function testeContarTodos()
    {
        (new Arquivo($this->usuarioId, 'texto1.txt', 'apenas um arquivo comum de texto1', '[hash-code]', '2021-05-24'))->salvar();
        (new Arquivo($this->usuarioId, 'texto2.txt', 'apenas um arquivo comum de texto2', '[hash-code]', '2021-05-24'))->salvar();
        $total = Arquivo::contarTodos();
        $this->verificar($total == 2);
    }

    public function testeDestruir()
    {
        $arquivo = new Arquivo($this->usuarioId, 'texto1.txt', 'apenas um arquivo comum de texto1', '[hash-code]', '2021-05-24');
        $arquivo->salvar();
        Arquivo::destruir($arquivo->getId());
        $query = DW3BancoDeDados::query('SELECT * FROM arquivos');
        $bdArquivo = $query->fetch();
        $this->verificar($bdArquivo === false);
    }
}
