<?php
namespace Teste;

use \Modelo\Usuario;
use \Framework\DW3Teste;
use \Framework\DW3Sessao;

class Teste extends DW3Teste
{
	protected $usuario;

	public function criarArquivoTxt()
	{
		// $arquivo = fopen( 'teste.txt','r');
		// if ($arquivo == false) die('Não foi possível criar o arquivo.');
		// fclose($arquivo);
	}
	public function logar()
	{
		$this->usuario = new Usuario('usuario@teste.com', '123', 'nome');
		$this->usuario->salvar();
		DW3Sessao::set('usuario', $this->usuario->getId());
	}
}
