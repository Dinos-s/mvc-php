<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página apagar usuário
 * @author Cesar <cesar@celke.com.br>
 */
class DeleteConfEmails
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deleteConfEmail = new \App\adms\Models\AdmsDeleteConfEmails();
            $deleteConfEmail->deleteConfEmails($this->id);            
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar uma configuração de email!</p>";
        }

        $urlRedirect = URLADM . "list-conf-emails/index";
        header("Location: $urlRedirect");

    }
}
