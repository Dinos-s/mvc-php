<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a menu da página no banco de dados
 */
class AdmsEditPrintMenu {
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

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

    public function editPrintMenu(int $id): void
    {
        $this->id = $id;

        $viewPrintMenu = new \App\adms\Models\helper\AdmsRead();
        $viewPrintMenu->fullRead(
            "SELECT lev_pg.id, lev_pg.print_menu
            FROM adms_levels_pages lev_pg
            INNER JOIN adms_access_levels AS lev 
            ON lev.id = lev_pg.adms_access_level_id
            WHERE lev_pg.id =:id 
            AND lev.order_levels >=:order_levels
            LIMIT :limit", 
            "id={$this->id}&order_levels=". $_SESSION['order_levels'] ."&limit=1"
        );

        $this->resultBD = $viewPrintMenu->getResult();
        if ($this->resultBD) {
            $this->edit();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: A página selecionada não é válida!</p>";
            $this->result = false;
        }
    }

    private function edit(){
        if ($this->resultBD[0]['print_menu'] == 1) {
            $this->data['print_menu'] = 2;
        } else {
            $this->data['print_menu'] = 1;
        }
        $this->data['modificado'] = date("Y-m-d H:i:s");

        $upPrintMenu = new \App\adms\Models\helper\AdmsUpdate();
        $upPrintMenu->exeUpdate("adms_levels_pages", $this->data, "WHERE id =:id", "id={$this->id}");

        if($upPrintMenu->getResult()){
            $_SESSION['msg'] = "<p style='color: green'>Item do menu editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: green'>Erro: Falha ao editar a Item do menu!</p>";
            $this->result = false;
        }
    }
}
