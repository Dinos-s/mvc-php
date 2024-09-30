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

        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_access_levels'=>['menu_controller'=>'add-access-levels', 'menu_metodo'=>'index'],
            'sync_pages_levels'=>['menu_controller'=>'sync-pages-levels', 'menu_metodo'=>'index'],
            'order_access_levels'=>['menu_controller'=>'order-access-levels', 'menu_metodo'=>'index'],
            'list_permission'=>['menu_controller'=>'list-permission', 'menu_metodo'=>'index'],
            'list_access_levels'=>['menu_controller'=>'list-access-levels', 'menu_metodo'=>'index'],
            'view_access_levels'=>['menu_controller'=>'view-access-levels', 'menu_metodo'=>'index'],
            'edit_access_levels'=>['menu_controller'=>'edit-access-levels', 'menu_metodo'=>'index'],
            'delete_access_levels'=>['menu_controller'=>'delete-access-levels', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $this->data['pag'] = $this->page;
        $loadView = new \Core\ConfigView("adms/Views/accessLevels/listAccessLevels", $this->data);
        $loadView->loadView();
    }
}
