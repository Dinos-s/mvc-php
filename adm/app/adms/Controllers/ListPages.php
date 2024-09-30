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
        
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_pages'=>['menu_controller'=>'add-pages', 'menu_metodo'=>'index'],
            'sync_pages_levels'=>['menu_controller'=>'sync-pages-levels', 'menu_metodo'=>'index'],
            'view_pages'=>['menu_controller'=>'view-pages', 'menu_metodo'=>'index'],
            'edit_pages'=>['menu_controller'=>'edit-pages', 'menu_metodo'=>'index'],
            'delete_pages'=>['menu_controller'=>'delete-pages', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $this->data['pag'] = $this->page;
        $loadView = new \Core\ConfigView("adms/Views/pages/listPages", $this->data);
        $loadView->loadView();
    }
}
