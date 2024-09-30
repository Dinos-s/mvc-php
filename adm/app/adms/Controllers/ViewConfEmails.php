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
class ViewConfEmails
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

            $viewConfEmails = new \App\adms\Models\AdmsViewConfEmails();
            $viewConfEmails->viewConfEmails($this->id);
            if ($viewConfEmails->getResult()) {
                $this->data['viewConfEmails'] = $viewConfEmails->getResultBd();
                $this->viewConfEmails();
            } else {
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewConfEmails(): void
    {
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'add_conf_emails'=>['menu_controller'=>'add-conf-emails', 'menu_metodo'=>'index'],
            'list_conf_emails'=>['menu_controller'=>'list-conf-emails', 'menu_metodo'=>'index'],
            'edit_conf_emails'=>['menu_controller'=>'edit-conf-emails', 'menu_metodo'=>'index'],
            'edit_conf_emails_password'=>['menu_controller'=>'edit-conf-emails-password', 'menu_metodo'=>'index'],
            'delete_conf_emails'=>['menu_controller'=>'delete-conf-emails', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);

        $loadView = new \Core\ConfigView("adms/Views/confEmails/viewConfEmail", $this->data);
        $loadView->loadView();
    }
}
