<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página listar grupos de páginas
 * @author Cesar <cesar@celke.com.br>
 */
class ListGroupsPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;
        
        $listGroupsPages = new \App\adms\Models\AdmsListGroupsPages();
        $listGroupsPages->listGroupsPages($this->page);
        if($listGroupsPages->getResult()){
            $this->data['listGroupsPages'] = $listGroupsPages->getResultBd(); 
            $this->data['pagination'] = $listGroupsPages->getResultPg();
        }else{
            $this->data['listGroupsPages'] = [];
        }

        $this->data['pag'] = $this->page;
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/listGroupsPages", $this->data);
        $loadView->loadView();
    }
}
