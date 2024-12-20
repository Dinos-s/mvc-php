<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar usuarios
 * @author Cesar <cesar@celke.com.br>
 */
class ViewColors
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

            $viewColor = new \App\adms\Models\AdmsViewColors();
            $viewColor->viewColor($this->id);
            if ($viewColor->getResult()) {
                $this->data['viewColor'] = $viewColor->getResultBd();
                $this->viewColor();
            } else {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor não encontrada!</p>";
            $urlRedirect = URLADM . "list-colors/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewColor(): void
    {
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'list_colors'=>['menu_controller'=>'list-colors', 'menu_metodo'=>'index'],
            'edit_colors'=>['menu_controller'=>'edit-colors', 'menu_metodo'=>'index'],
            'edit_colors'=>['menu_controller'=>'edit-colors', 'menu_metodo'=>'index'],
            'delete_colors'=>['menu_controller'=>'delete-colors', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/colors/viewColor", $this->data);
        $loadView->loadView();
    }
}
