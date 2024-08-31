<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da pagina SyncPagesLevels
 * @author Cesar <cesar@celke.com.br>
 */
class SyncPagesLevels {
    /**
     * Instantiar a classe responsavel em sincronizar os niveis de acesso.
     * 
     * @return void
     */
    public function index():void
    {
        $SyncPagesLevels = new \App\adms\Models\AdmsSyncPagesLevels();
        $SyncPagesLevels->SyncPagesLevels();
    }
}