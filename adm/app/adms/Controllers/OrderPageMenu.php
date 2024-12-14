<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página Altera a ordem do nivel de acesso
 * @author Cesar <cesar@celke.com.br>
 */
class OrderPageMenu
{
    /** @var int|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private int|string|null $level;

    private int|string|null $pag;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->id = (int) $id;
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);
        $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
        
        if ((!empty($id)) and (!empty($this->pag)) and (!empty($this->level))) {
            $orderMenu = new \App\adms\Models\AdmsOrderPageMenu();
            $orderMenu->editOrder($this->id);

            $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
            header("Location: $urlRedirect");
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nescessário selecionar um item de menu!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}