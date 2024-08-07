<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página apagar um página
 * @author Cesar <cesar@celke.com.br>
 */
class DeleteSitsPages
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deletePages = new \App\adms\Models\AdmsDeleteSitsPages();
            $deletePages->deleteSitsPages($this->id);            
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar uma página!</p>";
        }

        $urlRedirect = URLADM . "list-sits-pages/index";
        header("Location: $urlRedirect");

    }
}
