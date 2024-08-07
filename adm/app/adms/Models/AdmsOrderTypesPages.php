<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Alterar a ordem de acesso no banco de dados
 *
 * @author Celke
 */
class AdmsOrderTypesPages
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
     * Metodo para alterar ordem do nivel de acesso
     * Recebe o ID do nivel de acesso que sera usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
    */
    public function ordemTipos(int $id): void
    {
        $this->id = $id;

        $viewtypePage = new \App\adms\Models\helper\AdmsRead();
        $viewtypePage->fullRead(
            "SELECT id, order_type_pg 
            FROM adms_types_pgs 
            WHERE id=:id 
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBD = $viewtypePage->getResult();
        if ($this->resultBD) {
            // $this->result = true;
            $this->viewPrevTypePage();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Tipo de página não encontrado!</p>";
            $this->result = false;
        }
    }

    private function viewPrevTypePage():void {
        $prevtypePage = new \App\adms\Models\helper\AdmsRead();
        $prevtypePage->fullRead(
            "SELECT id, order_type_pg 
            FROM adms_types_pgs 
            WHERE order_type_pg <:order_type_pg
            ORDER BY order_type_pg DESC 
            LIMIT :limit",
            "order_type_pg={$this->resultBD[0]['order_type_pg']}&limit=1"
        );

        $this->resultBDPrev = $prevtypePage->getResult();
        if ($this->resultBDPrev) {
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Tipo de página não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do nivel de acesso superior para ser inferior
     * Retorna FALSE se houver algum erro.
     * @return void
    */
    private function editMoveDown():void {
        $this->data['order_type_pg'] = $this->resultBD[0]['order_type_pg'];
        $this->data['modificado'] = date('Y-m-d H:i:s');

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultBDPrev[0]['id']}");

        if($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Ordem do tipo de página não pode ser editado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do nivel de acesso inferior para ser superior
     * Retorna FALSE se houver algum erro.
     * @return void
    */
    private function editMoveUp() {
        $this->data['order_type_pg'] = $this->resultBDPrev[0]['order_type_pg'];
        $this->data['modificado'] = date('Y-m-d H:i:s');

        $moveUp = new \App\adms\Models\helper\AdmsUpdate();
        $moveUp->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultBD[0]['id']}");

        if ($moveUp->getResult()) {
            $_SESSION['msg'] = "<p style='color: green'>Ordem do tipo de página editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Ordem do tipo de página não pode ser editado!</p>";
            $this->result = false;
        }
    }
}
