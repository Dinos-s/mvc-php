<?php

namespace App\cpms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da pagina Dashboard
 * @author Cesar <cesar@celke.com.br>
 */
class GeneratePdf {
    private int|string|null $id;

    public function index(int|string|null $id = null):void {
        if (!empty($id)) {
            $this->id = (int) $id;

            $GerarPdf = new \App\cpms\Models\CpmsGeneratePdf();
            $GerarPdf->viewUser($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}