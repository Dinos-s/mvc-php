<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a permissão da página no banco de dados
 */
class AdmsEditPermission {
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

    public function editPermission(int $id): void
    {
        $this->id = $id;

        $viewPermission = new \App\adms\Models\helper\AdmsRead();
        $viewPermission->fullRead(
            "SELECT lev_pg.id, lev_pg.permission
            FROM adms_levels_pages lev_pg
            INNER JOIN adms_access_levels AS lev 
            ON lev.id = lev_pg.adms_access_level_id
            LEFT JOIN adms_pages AS pag ON pag.id = lev_pg.adms_page_id
            WHERE lev_pg.id =:id 
            AND lev.order_levels >:order_levels
            AND (((SELECT permission FROM adms_levels_pages WHERE adms_page_id=lev_pg.adms_page_id 
            AND adms_access_level_id = {$_SESSION['adms_access_levels_id']}) = 1) 
            OR (publish = 1))
            LIMIT :limit", 
            "id={$this->id}&order_levels=". $_SESSION['order_levels'] ."&limit=1"
        );

        $this->resultBD = $viewPermission->getResult();
        if ($this->resultBD) {
            $this->edit();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: A página selecionada não é válida!</p>";
            $this->result = false;
        }
    }

    private function edit(){
        if ($this->resultBD[0]['permission'] == 1) {
            $this->data['permission'] = 2;
        } else {
            $this->data['permission'] = 1;
        }
        $this->data['modificado'] = date("Y-m-d H:i:s");

        $upPermission = new \App\adms\Models\helper\AdmsUpdate();
        $upPermission->exeUpdate("adms_levels_pages", $this->data, "WHERE id =:id", "id={$this->id}");

        if($upPermission->getResult()){
            $_SESSION['msg'] = "<p style='color: green'>Permissão editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: green'>Erro: Falha ao editar a Permissão!</p>";
            $this->result = false;
        }
    }
}
