<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página listar os tipos de páginas
 * @author Cesar <cesar@celke.com.br>
 */
class ListTypesPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;
        
        $listTypesPages = new \App\adms\Models\AdmsListTypesPages();
        $listTypesPages->listTypesPages($this->page);
        if($listTypesPages->getResult()){
            $this->data['listTypesPages'] = $listTypesPages->getResultBd(); 
            $this->data['pagination'] = $listTypesPages->getResultPg();
        }else{
            $this->data['listTypesPages'] = [];
        }
        
        $this->data['pag'] = $this->page;
        $loadView = new \Core\ConfigView("adms/Views/typesPages/listTypesPages", $this->data);
        $loadView->loadView();
    }
}
