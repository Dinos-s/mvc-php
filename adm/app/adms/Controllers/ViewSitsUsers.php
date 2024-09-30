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
class ViewSitsUsers
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

            $viewSitUser = new \App\adms\Models\AdmsViewSitsUsers();
            $viewSitUser->viewSitUser($this->id);
            if ($viewSitUser->getResult()) {
                $this->data['viewSitUser'] = $viewSitUser->getResultBd();
                $this->viewSitUser();
            } else {
                $urlRedirect = URLADM . "list-sits-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação não encontrada!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewSitUser(): void
    {
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'list_sits_users'=>['menu_controller'=>'list-sits-users', 'menu_metodo'=>'index'],
            'edit_sits_users'=>['menu_controller'=>'edit-sits-users', 'menu_metodo'=>'index'],
            'delete_sits_users'=>['menu_controller'=>'delete-sits-users', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/sitsUser/viewSitsUser", $this->data);
        $loadView->loadView();
    }
}
