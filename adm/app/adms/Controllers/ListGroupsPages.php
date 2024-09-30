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

        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_groups_pages'=>['menu_controller'=>'add-groups-pages', 'menu_metodo'=>'index'],
            'order_groups_pages'=>['menu_controller'=>'order-groups-pages', 'menu_metodo'=>'index'],
            'view_groups_pages'=>['menu_controller'=>'view-groups-pages', 'menu_metodo'=>'index'],
            'edit_groups_pages'=>['menu_controller'=>'edit-groups-pages', 'menu_metodo'=>'index'],
            'delete_groups_pages'=>['menu_controller'=>'delete-groups-pages', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $this->data['pag'] = $this->page;
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/listGroupsPages", $this->data);
        $loadView->loadView();
    }
}
