<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar a situação das páginas
 * @author Cesar <cesar@celke.com.br>
 */
class ViewSitsPages
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

            $viewSitPages = new \App\adms\Models\AdmsViewSitsPages();
            $viewSitPages->viewSitPage($this->id);
            if ($viewSitPages->getResult()) {
                $this->data['viewSitPages'] = $viewSitPages->getResultBd();
                $this->viewSitPages();
            } else {
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação não encontrada!</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewSitPages(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/sitsPages/viewSitsPages", $this->data);
        $loadView->loadView();
    }
}
