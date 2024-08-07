<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página listar páginas
 * @author Cesar <cesar@celke.com.br>
 */
class ListPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;
        
        $listPages = new \App\adms\Models\AdmsListPages();
        $listPages->listPages($this->page);
        if($listPages->getResult()){
            $this->data['listPages'] = $listPages->getResultBd(); 
            $this->data['pagination'] = $listPages->getResultPg();
        }else{
            $this->data['listPages'] = [];
        }
        
        $this->data['pag'] = $this->page;
        $loadView = new \Core\ConfigView("adms/Views/pages/listPages", $this->data);
        $loadView->loadView();
    }
}
