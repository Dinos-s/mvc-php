<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página listar usuarios
 * @author Cesar <cesar@celke.com.br>
 */
class ListAccessLevels
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;
        $listAccessLevels = new \App\adms\Models\AdmsListAccessLevels();
        $listAccessLevels->listAccessLevels($this->page);
        if($listAccessLevels->getResult()){
            $this->data['listAccessLevels'] = $listAccessLevels->getResultBd(); 
            $this->data['pagination'] = $listAccessLevels->getResultPg();
        }else{
            $this->data['listAccessLevels'] = [];
        }

        $loadView = new \Core\ConfigView("adms/Views/accessLevels/listAccessLevels", $this->data);
        $loadView->loadView();
    }
}
