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

        $button = [
            'add_types_pages'=>['menu_controller'=>'add-types-pages', 'menu_metodo'=>'index'],
            'order_types_pages'=>['menu_controller'=>'order-types-pages', 'menu_metodo'=>'index'],
            'view_types_pages'=>['menu_controller'=>'view-types-pages', 'menu_metodo'=>'index'],
            'edit_types_pages'=>['menu_controller'=>'edit-types-pages', 'menu_metodo'=>'index'],
            'delete_types_pages'=>['menu_controller'=>'delete-types-pages', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);
        
        $this->data['pag'] = $this->page;
        $loadView = new \Core\ConfigView("adms/Views/typesPages/listTypesPages", $this->data);
        $loadView->loadView();
    }
}
