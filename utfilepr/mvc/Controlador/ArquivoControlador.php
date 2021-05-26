<?php
namespace Controlador;
use \Framework\DW3Sessao;
use \Modelo\Arquivo;
class ArquivoControlador extends Controlador
{
    private function getOrderBy()
    {
        $orderBy = "";
        if (array_key_exists('curtida', $_GET))
        {
            $curtida = $_GET['curtida'];
            if($curtida == strtolower('desc')) 
                $orderBy .= 'qtd_curtida DESC';
            if($curtida == strtolower('asc')) 
                $orderBy .= 'qtd_curtida ASC';
        }
        if (array_key_exists('data', $_GET))
        {
            $data = $_GET['data'];
            if($data == strtolower('desc')) 
                $orderBy .= 'a.data_upload DESC';
            if($data == strtolower('asc')) 
                $orderBy .= 'a.data_upload ASC';
        }
        return $orderBy;
    }
    private function calcularPaginacao()
    {
        $pagina = array_key_exists('p', $_GET) ? intval($_GET['p']) : 1;
        $limit = 4;
        $offset = ($pagina - 1) * $limit;
        $arquivos = Arquivo::buscarTodos($this->getOrderBy(), $limit, $offset);
        $arquivosTodos = Arquivo::buscarTodos($this->getOrderBy(), 9999, 0);
        $ultimaPagina = ceil(Arquivo::contarTodos() / $limit);
        return compact('pagina', 'arquivos', 'arquivosTodos', 'ultimaPagina');
    }
    private function gerarRelatorio()
    {
    }
    private function deletarArquivo($id)
    {
        $arquivo= Arquivo::buscarId($id);
        $path = 'publico/arquivos/' . $arquivo->getUsuarioId() . '/' . $arquivo->getHashArquivo();
        try {
            if (file_exists($path))
            {
                unlink ($path);
            }
        } catch (Exception $e) {
            echo "Não foi excluir o arquivo! \n", $e->getMessage(), "\n";
        }
    }
    private function criarPastaUpload()
    {
        try {
            $path = 'publico/arquivos/'.DW3Sessao::get('usuario');
            if (!is_dir($path))
            {
                mkdir($path, 0777, true);
            }
            if(is_dir($path)) 
            {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "Não foi possível criar a pasta para upload! \n", $e->getMessage(), "\n";
        }
    }
    private function getExtensao($nomeDoArquivo) 
    {
        return pathinfo($nomeDoArquivo, PATHINFO_EXTENSION);
    }
    private function getNomeArquivo($nomeDoArquivo) 
    {
        return pathinfo($nomeDoArquivo, PATHINFO_FILENAME);
    }
    private function getDataAtual()
    {
        return date("Y-m-d H:i:s");
    }
    public function index()
    {
        $this->verificarLogado();
        $paginacao = $this->calcularPaginacao();
        $this->visao('arquivos/index.php', [
            'arquivos' => $paginacao['arquivos'],
            'arquivosTodos' => $paginacao['arquivosTodos'],
            'pagina' => $paginacao['pagina'],
            'ultimaPagina' => $paginacao['ultimaPagina'],
            'mensagemFlash' => DW3Sessao::getFlash('mensagemFlash')
        ]);
    }
    public function armazenar()
    {
        $this->verificarLogado();
        if(isset($_FILES['arquivo']))
        {
            $arquivo = $_FILES['arquivo'];
            $arquivoNome = $this->getNomeArquivo($arquivo['name']);
            $extensao = $this->getExtensao($arquivo['name']);
            $nomeResumido = strlen($arquivoNome) > 30 ? substr($arquivoNome, 0, 30) : $arquivoNome;
            $hash_code = md5(uniqid($arquivo['name'])).".".$extensao;
            if($this->criarPastaUpload())
            {
                $diretorio = 'publico/arquivos/' . DW3Sessao::get('usuario') . '/';
                if( move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$hash_code))
                {
                    $arquivo = new Arquivo(
                        DW3Sessao::get('usuario'),
                        ($nomeResumido . "." . $extensao),
                        $_POST['descricao'],
                        $hash_code,
                        $this->getDataAtual(),
                        null,
                        null,
                        null
                    );
                    if ($arquivo->isValido()) {
                        $arquivo->salvar();
                        DW3Sessao::setFlash('mensagemFlash', 'Arquivo cadastrado com sucesso!');
                        $this->redirecionar(URL_RAIZ . 'arquivos');
                    }  else {
                        $paginacao = $this->calcularPaginacao();
                        $this->setErros($arquivo->getValidacaoErros());
                        $this->visao('arquivos/index.php', [
                            'arquivos' => $paginacao['arquivos'],
                            'pagina' => $paginacao['pagina'],
                            'ultimaPagina' => $paginacao['ultimaPagina'],
                            'mensagemFlash' => DW3Sessao::getFlash('mensagemFlash')
                        ]);
                    }
                }
            }
        } 
    }
    public function atualizar($id)
    {          
        $this->verificarLogado();
        $arquivo = Arquivo::buscarId($id);

        if ($arquivo->getUsuarioId() == $this->getUsuario()) {
         
            if(isset($_POST['nova-descricao']))
            {
                $novaDescricao = $_POST['nova-descricao'];
                $arquivo = Arquivo::buscarId($id);
                $arquivo->atualizarDescricao($novaDescricao, $id);
                DW3Sessao::setFlash('mensagemFlash', 'A descrição do arquivo foi atualizada.');
                $this->redirecionar(URL_RAIZ . 'arquivos');
            } 
            else
            {
                DW3Sessao::setFlash('mensagem', 'Nenhuma descrição enviada.');
            }
            
        } else {
            DW3Sessao::setFlash('mensagemFlash', 'Ops! Você não pode editar o arquivo de outras pessoas!');
            $this->redirecionar(URL_RAIZ . 'arquivos');
        }

      
    }
    public function destruir($id)
    {
        $this->verificarLogado();
        $arquivo = Arquivo::buscarId($id);
        if ($arquivo->getUsuarioId() == $this->getUsuario()) {
            if (true)
            {
                $this->deletarArquivo($id);
            }
            Arquivo::destruir($id);
            DW3Sessao::setFlash('mensagemFlash', 'Arquivo deletado com sucesso.');
        } else {
            DW3Sessao::setFlash('mensagemFlash', 'Ops! É proibido excluir arquivos de outras pessoas!');
        }
        $this->redirecionar(URL_RAIZ . 'arquivos');
    }
}
