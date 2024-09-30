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
class ListSitsUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page =null)
    {
        $this->page = (int) $page ? $page : 1;
        $listSitsUsers = new \App\adms\Models\AdmsListSitsUsers();
        $listSitsUsers->listSitsUsers($this->page);
        if($listSitsUsers->getResult()){
            $this->data['listSitsUsers'] = $listSitsUsers->getResultBd(); 
            $this->data['pagination'] = $listSitsUsers->getResultPg();
        }else{
            $this->data['listSitsUsers'] = [];
        }

        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_sits_users'=>['menu_controller'=>'add-sits-users', 'menu_metodo'=>'index'],
            'view_sits_users'=>['menu_controller'=>'view-sits-users', 'menu_metodo'=>'index'],
            'edit_sits_users'=>['menu_controller'=>'edit-sits-users', 'menu_metodo'=>'index'],
            'delete_sits_users'=>['menu_controller'=>'delete-sits-users', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/sitsUser/listSitsUsers", $this->data);
        $loadView->loadView();
    }
}
