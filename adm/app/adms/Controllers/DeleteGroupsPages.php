<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página apagar grupo de páginas
 * @author Cesar <cesar@celke.com.br>
 */
class DeleteGroupsPages
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    /**
     * Método apagar grupo de página
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senão criar a mensagem de erro
     * Redireciona para a página listar grupo de página
    */
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deleteGroupsPages = new \App\adms\Models\AdmsDeleteGroupsPages();
            $deleteGroupsPages->deleteGroupsPage($this->id);            
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar um grupo da página!</p>";
        }

        $urlRedirect = URLADM . "list-groups-pages/index";
        header("Location: $urlRedirect");

    }
}
