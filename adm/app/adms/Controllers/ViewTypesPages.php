<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar o tipo de página
 * @author Cesar <cesar@celke.com.br>
 */
class ViewTypesPages
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

            $viewTypesPages = new \App\adms\Models\AdmsViewTypesPages();
            $viewTypesPages->viewTypePage($this->id);
            if ($viewTypesPages->getResult()) {
                $this->data['viewTypesPages'] = $viewTypesPages->getResultBd();
                $this->viewTypesPages();
            } else {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tipo de Página não encontrado!</p>";
            $urlRedirect = URLADM . "list-types-pages/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewTypesPages(): void
    {
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'list_types_pages'=>['menu_controller'=>'list-types-pages', 'menu_metodo'=>'index'],
            'edit_types_pages'=>['menu_controller'=>'edit-types-pages', 'menu_metodo'=>'index'],
            'delete_types_pages'=>['menu_controller'=>'delete-types-pages', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/typesPages/viewTypesPages", $this->data);
        $loadView->loadView();
    }
}
