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
class ListUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;
        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers($this->page);
        if($listUsers->getResult()){
            $this->data['listUsers'] = $listUsers->getResultBd(); 
            $this->data['pagination'] = $listUsers->getResultPg();
        }else{
            $this->data['listUsers'] = [];
        }

        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_users'=>['menu_controller'=>'add-users', 'menu_metodo'=>'index'],
            'list_users'=>['menu_controller'=>'list-users', 'menu_metodo'=>'index'],
            'view_users'=>['menu_controller'=>'view-users', 'menu_metodo'=>'index'],
            'edit_users'=>['menu_controller'=>'edit-users', 'menu_metodo'=>'index'],
            'delete_users'=>['menu_controller'=>'delete-users', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();
    }
}
