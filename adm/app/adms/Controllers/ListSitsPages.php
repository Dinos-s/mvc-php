<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página listar situação da página
 * @author Cesar <cesar@celke.com.br>
 */
class ListSitsPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page =null)
    {
        $this->page = (int) $page ? $page : 1;
        $listSitsPages = new \App\adms\Models\AdmsListSitsPages();
        $listSitsPages->listSitsPages($this->page);
        if($listSitsPages->getResult()){
            $this->data['listSitsPages'] = $listSitsPages->getResultBd(); 
            $this->data['pagination'] = $listSitsPages->getResultPg();
        }else{
            $this->data['listSitsPages'] = [];
        }

        $loadView = new \Core\ConfigView("adms/Views/sitsPages/listSitsPages", $this->data);
        $loadView->loadView();
    }
}
