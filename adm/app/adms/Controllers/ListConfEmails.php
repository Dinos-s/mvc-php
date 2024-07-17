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
class ListConfEmails
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;
        
        $listConfEmails = new \App\adms\Models\AdmsListConfEmails();
        $listConfEmails->listConfEmails($this->page);
        if($listConfEmails->getResult()){
            $this->data['listConfEmails'] = $listConfEmails->getResultBd(); 
            $this->data['pagination'] = $listConfEmails->getResultPg();
        }else{
            $this->data['listConfEmails'] = [];
        }

        $loadView = new \Core\ConfigView("adms/Views/confEmails/listConfEmails", $this->data);
        $loadView->loadView();
    }
}
