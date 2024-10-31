<?php

namespace App\cpms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar usuarios
 * @author Cesar <cesar@celke.com.br>
 */
class ViewUsers
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

            $viewUser = new \App\cpms\Models\CpmsViewUsers();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResult()) {
                $this->data['viewUser'] = $viewUser->getResultBd();
                $this->viewUser();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewUser(): void
    {
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'list_users'=>['menu_controller'=>'list-users', 'menu_metodo'=>'index'],
            'edit_users'=>['menu_controller'=>'edit-users', 'menu_metodo'=>'index'],
            'edit_users'=>['menu_controller'=>'edit-users', 'menu_metodo'=>'index'],
            'edit_users_password'=>['menu_controller'=>'edit-users-password', 'menu_metodo'=>'index'],
            'edit_users_image'=>['menu_controller'=>'edit-users-image', 'menu_metodo'=>'index'],
            'delete_users'=>['menu_controller'=>'delete-users', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("cpms/Views/users/viewUser", $this->data);
        $loadView->loadView();
    }
}
