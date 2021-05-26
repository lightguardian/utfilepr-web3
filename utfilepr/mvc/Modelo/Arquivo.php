<?php
namespace Modelo;
use \PDO;
use DateTime;
use \Framework\DW3BancoDeDados;
class Arquivo extends Modelo
{
    const BUSCAR_TODOS =  'SELECT a.nome AS a_nome, a.descricao, a.hash_arquivo, a.data_upload, a.id a_id, a.usuario_id, (SELECT COUNT(arquivo_id) FROM curtidas WHERE arquivo_id = a_id AND status_curtida = 1) AS qtd_curtida, u.id u_id, u.nome AS u_nome, u.email FROM arquivos a JOIN usuarios u ON (a.usuario_id = u.id)'; 
    const BUSCAR_ID = 'SELECT *, (SELECT COUNT(arquivo_id) FROM curtidas WHERE arquivo_id = id AND status_curtida = 1) AS qtd_curtida  FROM arquivos WHERE id = ? LIMIT 1';
    const INSERIR = 'INSERT INTO arquivos(usuario_id, nome, descricao, hash_arquivo, data_upload) VALUES (?, ?, ?, ?, ?)';
    const DELETAR = 'DELETE FROM arquivos WHERE id = ?';
    const ATUALIZAR_DESCRICAO = 'UPDATE arquivos SET descricao = ? WHERE id = ?';
    const CONTAR_TODOS = 'SELECT count(id) FROM arquivos';
    private $id;
    private $usuarioId;
    private $nome;
    private $descricao;
    private $hash_arquivo;
    private $data_upload;
    private $usuario;
    private $qtd_curtida;
    public function __construct(
        $usuarioId,
        $nome,
        $descricao,
        $hash_arquivo,
        $data_upload,
        $usuario = null,
        $id = null,
        $qtd_curtida = null
    ) {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->hash_arquivo = $hash_arquivo;
        $this->data_upload = $data_upload;
        $this->usuario = $usuario;
        $this->qtd_curtida = $qtd_curtida;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function getQuantidadeCurtida()
    {
        return $this->qtd_curtida;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getHashArquivo()
    {
        return $this->hash_arquivo;
    }
    public function getDataFormatada($formato='d-m-Y H:i:s')
    {
        $dataFormatada = new DateTime($this->data_upload);
        return $dataFormatada->format($formato);
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }
    public function salvar()
    {
        $this->inserir();
    }
    private function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->usuarioId, PDO::PARAM_INT);
        $comando->bindValue(2, $this->nome, PDO::PARAM_STR);
        $comando->bindValue(3, $this->descricao, PDO::PARAM_STR);
        $comando->bindValue(4, $this->hash_arquivo, PDO::PARAM_STR);
        $comando->bindValue(5, $this->data_upload, PDO::PARAM_STR);
        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }
    public static function buscarId($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $objeto = null;
        $registro = $comando->fetch();
        if ($registro) {
            $objeto = new Arquivo(
                $registro['usuario_id'],
                $registro['nome'],
                $registro['descricao'],
                $registro['hash_arquivo'],
                $registro['data_upload'],
                null,
                $registro['id'],
                $registro['qtd_curtida']
            );
        }
        return $objeto;
    }
    public static function buscarTodos($orderBy = "",$limit = 4, $offset = 0)
    {   
        // Verifica orderBy por motivos de segurança
        $listaBranca = [
            'qtd_curtida ASC',
            'qtd_curtida DESC',
            'a.data_upload ASC',
            'a.data_upload DESC',
            'a.id ASC',
            'a.id DESC',
            'a_nome ASC',
            'a_nome DESC'
        ];
        $orderBy = in_array($orderBy, $listaBranca) ? $orderBy : "a.id";
        $buscarTodosCustom = self::BUSCAR_TODOS . 'ORDER BY ' . $orderBy .' LIMIT ? OFFSET ?';
        $comando = DW3BancoDeDados::prepare($buscarTodosCustom);
        $comando->bindValue(1, $limit, PDO::PARAM_INT);
        $comando->bindValue(2, $offset, PDO::PARAM_INT);
        $comando->execute();
        $registros = $comando->fetchAll();
        $objetos = [];
        foreach ($registros as $registro) {
            $usuario = new Usuario(
                $registro['email'],
                '',
                $registro['u_nome'],
                null,
                $registro['u_id']
            );
            $objetos[] = new Arquivo(
                $registro['u_id'],
                $registro['a_nome'],
                $registro['descricao'],
                $registro['hash_arquivo'],
                $registro['data_upload'],
                $usuario,
                $registro['a_id'],
                $registro['qtd_curtida']
            );
        }
        return $objetos;
    }
    public static function atualizarDescricao($novaDescricao,$id)
    {
        $comando = DW3BancoDeDados::prepare(self::ATUALIZAR_DESCRICAO);
        $comando->bindValue(1, $novaDescricao, PDO::PARAM_STR);
        $comando->bindValue(2, $id, PDO::PARAM_INT);
        $comando->execute();
    } 
    public static function contarTodos()
    {
        $registros = DW3BancoDeDados::query(self::CONTAR_TODOS);
        $total = $registros->fetch();
        return intval($total[0]);
    }
    public static function destruir($id)
    {
        $comando = DW3BancoDeDados::prepare(self::DELETAR);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
    }
    protected function verificarErros()
    {
        if (strlen($this->descricao) < 3) {
            $this->setErroMensagem('texto', 'Mínimo 3 caracteres.');
        }
    }
}
