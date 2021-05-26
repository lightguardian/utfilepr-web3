<?php
namespace Controlador;

use \Framework\DW3Sessao;
use \Modelo\Curtida;

class CurtidaControlador extends Controlador
{
   
    private function getDataAtual()
    {
        return date("Y-m-d H:i:s");
    }
    
    public function armazenar()
    {
        $this->verificarLogado();

        $statusValor = 1;
        if(isset($_POST['idArquivo']))
        {
            $currentUserId = DW3Sessao::get('usuario');
            $idArquivo = $_POST['idArquivo'];
            $pagina = $_POST['pagina'];

            $curtida = new Curtida(
                $currentUserId,
                $idArquivo,
                1,
                $this->getDataAtual()
            );

            if ($curtida->isValido()) {

                if($curtida->buscarId($currentUserId, $idArquivo) != null)
                {
                    $curtidaAux = $curtida->buscarId($currentUserId, $idArquivo);
                    $statusValor = $curtidaAux->getStatus() == 1 ? 0 : 1 ;
                    $curtida->atualizarStatus($statusValor, $currentUserId, $idArquivo);
                } else {
                    $curtida->salvar();
                }
                $this->redirecionar(URL_RAIZ . 'arquivos?p=' . $pagina . '#arquivo-' . $idArquivo);
            }  

        }
    }

    public function destruir($id)
    {
        $this->verificarLogado();
  
    }
}
