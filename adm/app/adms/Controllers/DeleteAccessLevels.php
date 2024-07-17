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
class DeleteAccessLevels
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deleteAccessLevel = new \App\adms\Models\AdmsDeleteAccessLevels();
            $deleteAccessLevel->deleteAccessLevel($this->id);            
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar um nível de acesso!</p>";
        }

        $urlRedirect = URLADM . "list-access-levels/index";
        header("Location: $urlRedirect");

    }
}
