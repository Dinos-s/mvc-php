<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Alterar a ordem do item de menu no banco de dados
 *
 * @author GMR
 */
class AdmsOrderPageMenu
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    private array|string|null $data;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    private array|null $resultBDPrev;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBD;
    }

    /**
     * Metodo para alterar ordem do item de menu
     * Recebe o ID do item de menu que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
    */
    public function editOrder(int $id): void
    {
        $this->id = $id;

        $viewPagMenu = new \App\adms\Models\helper\AdmsRead();
        $viewPagMenu->fullRead(
            "SELECT lev_pag.id, lev_pag.order_level_page, lev_pag.adms_access_level_id
            FROM adms_levels_pages lev_pag   
            INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
            LEFT JOIN adms_pages AS pag ON pag.id=lev_pag.adms_page_id 
            WHERE lev_pag.id=:id 
            AND lev.order_levels >=:order_levels
            AND (((SELECT permission FROM adms_levels_pages 
            WHERE adms_page_id = lev_pag.adms_page_id 
            AND adms_access_level_id = {$_SESSION['adms_access_levels_id']}) = 1) 
            OR (publish = 1)) 
            LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] ."&limit=1"
        );

        $this->resultBD = $viewPagMenu->getResult();
        if ($this->resultBD) {
            // $this->result = true;
            $this->viewPrevPagMenu();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Item de menu não encontrado!</p>";
            $this->result = false;
        }
    }

    private function viewPrevPagMenu():void {
        $prevPagMenu = new \App\adms\Models\helper\AdmsRead();
        $prevPagMenu->fullRead(
            "SELECT lev_pag.id, lev_pag.order_level_page
            FROM adms_levels_pages AS lev_pag
            LEFT JOIN adms_pages AS pag ON pag.id = lev_pag.adms_page_id
            WHERE lev_pag.order_level_page <:order_level_page
            AND lev_pag.adms_access_level_id =:adms_access_level_id
            AND (((SELECT permission FROM adms_levels_pages 
            WHERE adms_page_id=lev_pag.adms_page_id 
            AND adms_access_level_id = {$_SESSION['adms_access_levels_id']}) = 1) 
            OR (publish = 1))
            ORDER BY lev_pag.order_level_page DESC
            LIMIT :limit", 
            "order_level_page={$this->resultBD[0]['order_level_page']}&adms_access_level_id={$this->resultBD[0]['adms_access_level_id']}&limit=1"
        );

        $this->resultBDPrev = $prevPagMenu->getResult();
        if ($this->resultBDPrev) {
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Item de menu não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do item de menu superior para ser inferior
     * Retorna FALSE se houver algum erro.
     * @return void
    */
    private function editMoveDown():void {
        $this->data['order_level_page'] = $this->resultBD[0]['order_level_page'];
        $this->data['modificado'] = date('Y-m-d H:i:s');

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->resultBDPrev[0]['id']}");

        if($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Ordem do item de menu não pode ser editado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do item de menu inferior para ser superior
     * Retorna FALSE se houver algum erro.
     * @return void
    */
    private function editMoveUp() {
        $this->data['order_level_page'] = $this->resultBDPrev[0]['order_level_page'];
        $this->data['modificado'] = date('Y-m-d H:i:s');

        $moveUp = new \App\adms\Models\helper\AdmsUpdate();
        $moveUp->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->resultBD[0]['id']}");

        if ($moveUp->getResult()) {
            $_SESSION['msg'] = "<p style='color: green'>Ordem do item de menu editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Ordem do item de menu não pode ser editado!</p>";
            $this->result = false;
        }
    }
}
