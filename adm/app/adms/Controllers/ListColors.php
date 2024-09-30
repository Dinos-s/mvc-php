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
class ListColors
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    private string|int|null $page;

    public function index(string|int|null $page =null)
    {
        $this->page = (int) $page ? $page : 1;
        $listSitsUsers = new \App\adms\Models\AdmsListColors();
        $listSitsUsers->listColors($this->page);
        if($listSitsUsers->getResult()){
            $this->data['listColors'] = $listSitsUsers->getResultBd(); 
            $this->data['pagination'] = $listSitsUsers->getResultPg();
        }else{
            $this->data['listColors'] = [];
        }

        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_colors'=>['menu_controller'=>'add-colors', 'menu_metodo'=>'index'],
            'view_colors'=>['menu_controller'=>'view-colors', 'menu_metodo'=>'index'],
            'edit_colors'=>['menu_controller'=>'edit-colors', 'menu_metodo'=>'index'],
            'delete_colors'=>['menu_controller'=>'delete-colors', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/colors/listColors", $this->data);
        $loadView->loadView();
    }
}
