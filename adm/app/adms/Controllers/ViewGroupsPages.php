<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar os grupos de páginas
 * @author Cesar <cesar@celke.com.br>
 */
class ViewGroupsPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewGroupsPages = new \App\adms\Models\AdmsViewGroupsPages();
            $viewGroupsPages->viewGroupsPages($this->id);
            if ($viewGroupsPages->getResult()) {
                $this->data['viewGroupsPages'] = $viewGroupsPages->getResultBd();
                $this->viewGroupsPages();
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Grupo de página não encontrado!</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewGroupsPages(): void
    {
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'list_groups_pages'=>['menu_controller'=>'list-groups-pages', 'menu_metodo'=>'index'],
            'edit_groups_pages'=>['menu_controller'=>'edit-groups-pages', 'menu_metodo'=>'index'],
            'delete_groups_pages'=>['menu_controller'=>'delete-groups-pages', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);
        
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/viewGroupsPages", $this->data);
        $loadView->loadView();
    }
}
