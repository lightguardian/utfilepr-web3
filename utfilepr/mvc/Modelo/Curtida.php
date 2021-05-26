<?php
namespace Modelo;

use \PDO;
use DateTime;

use \Framework\DW3BancoDeDados;

class Curtida extends Modelo
{
    const BUSCAR_TODOS =  'SELECT * FROM curtidas'; 
    const BUSCAR_ID = 'SELECT * FROM curtidas WHERE usuario_id = ? AND arquivo_id = ? LIMIT 1';
    const BUSCAR_POR_USUARIO= 'SELECT * FROM curtidas WHERE usuario_id = ?';
    const BUSCAR_POR_ARQUIVO = 'SELECT * FROM curtidas WHERE arquivo_id = ?';

    const ATUALIZAR_STATUS = 'UPDATE curtidas SET status_curtida = ? WHERE usuario_id = ? AND arquivo_id = ?';
    const INSERIR = 'INSERT INTO curtidas(usuario_id, arquivo_id, status_curtida, data_curtida) VALUES (?, ?, ?, ?)';
    const DELETAR = 'DELETE FROM arquivos WHERE usuario_id = ? AND arquivo_id = ?';
    const CONTAR_TODOS = 'SELECT count(*) FROM curtidas';
    const CONTAR_TODOS_USUARIO = 'SELECT count(*) FROM curtidas WHERE usuario_id = ?';
    const CONTAR_TODOS_ARQUIVO = 'SELECT count(*) FROM curtidas WHERE arquivo_id = ?';

    private $usuario_id;
    private $arquivo_id;
    private $status_curtida;
    private $data_curtida;
   
    public function __construct(
        $usuario_id,
        $arquivo_id,
        $status_curtida,
        $data_curtida
    ) {
        $this->usuario_id = $usuario_id;
        $this->arquivo_id = $arquivo_id;
        $this->status_curtida = $status_curtida;
        $this->data_curtida = $data_curtida;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function getArquivoId()
    {
        return $this->arquivo_id;
    }

    public function setStatus($novoStatus)
    {
        $this->status_curtida = $novoStatus;

    }
    public function getStatus()
    {
        return $this->status_curtida;
    }


    public function getDataCurtida()
    {
        return $this->data_curtida;
    }
  
    public function getDataFormatada($formato='d-m-Y H:i:s')
    {
        $dataFormatada = new DateTime($this->data_curtida);
        return $dataFormatada->format($formato);
    }

    public function salvar()
    {
        $this->inserir();
    }

    private function inserir()
    {   
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->usuario_id, PDO::PARAM_INT);
        $comando->bindValue(2, $this->arquivo_id, PDO::PARAM_INT);
        $comando->bindValue(3, $this->status_curtida, PDO::PARAM_INT);
        $comando->bindValue(4, $this->data_curtida, PDO::PARAM_STR);

        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }

   

    public static function buscarId($idUsuario, $idArquivo)
    {

        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $idUsuario, PDO::PARAM_INT);
        $comando->bindValue(2, $idArquivo, PDO::PARAM_INT);

        $comando->execute();
       
        $objeto = null;
        $registro = $comando->fetch();
       
        if ($registro) {
            $objeto = new Curtida(
                $registro['usuario_id'],
                $registro['arquivo_id'],
                $registro['status_curtida'],
                $registro['data_curtida']
            );
        }

        return $objeto;
    }

    public static function atualizarStatus($novoStatus, $idUsuario, $idArquivo)
    {
        $comando = DW3BancoDeDados::prepare(self::ATUALIZAR_STATUS);
        $comando->bindValue(1, $novoStatus, PDO::PARAM_INT);
        $comando->bindValue(2, $idUsuario, PDO::PARAM_INT);
        $comando->bindValue(3, $idArquivo, PDO::PARAM_INT);

        $comando->execute();
       
    }


    public static function contarTodos()
    {
        $registros = DW3BancoDeDados::query(self::CONTAR_TODOS);
        $total = $registros->fetch();
        return intval($total[0]);
    }

    public static function contarTodosPorArquivo($id)
    {  
        $comando = DW3BancoDeDados::prepare(self::CONTAR_TODOS_ARQUIVO);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
    
          
        $comando->execute();
        
        $total = $comando->fetch();
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
      
    }
}
