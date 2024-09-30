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
class ViewAccessLevels
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

            $viewAccessLevels = new \App\adms\Models\AdmsViewAccessLevels();
            $viewAccessLevels->viewAccessLevels($this->id);
            if ($viewAccessLevels->getResult()) {
                $this->data['viewAccessLevels'] = $viewAccessLevels->getResultBd();
                $this->viewAccessLevels();
            } else {
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nível de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewAccessLevels(): void
    {
        // variavel para ocultar caso o usuário não tenha a permissão
        $button = [
            'list_access_levels'=>['menu_controller'=>'list-access-levels', 'menu_metodo'=>'index'],
            'edit_access_levels'=>['menu_controller'=>'edit-access-levels', 'menu_metodo'=>'index'],
            'delete_access_levels'=>['menu_controller'=>'delete-access-levels', 'menu_metodo'=>'index']
        ];

        $listBtns = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBtns->buttonPermission($button);
        
        $loadView = new \Core\ConfigView("adms/Views/accessLevels/viewAccessLevel", $this->data);
        $loadView->loadView();
    }
}
