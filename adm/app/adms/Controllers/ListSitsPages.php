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

        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_sits_pages'=>['menu_controller'=>'add-sits-pages', 'menu_metodo'=>'index'],
            'view_sits_pages'=>['menu_controller'=>'view-sits-pages', 'menu_metodo'=>'index'],
            'edit_sits_pages'=>['menu_controller'=>'edit-sits-pages', 'menu_metodo'=>'index'],
            'delete_sits_pages'=>['menu_controller'=>'delete-sits-pages', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/sitsPages/listSitsPages", $this->data);
        $loadView->loadView();
    }
}
