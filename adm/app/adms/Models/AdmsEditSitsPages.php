<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar o usuário no banco de dados
 *
 * @author GMR
 */
class AdmsEditSitsPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $dataExitVal Recebe os campos que devem ser retirados da validação */
    private array|null $dataExitVal;

    private array $listRegistryEdit;

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

    public function viewSitsPage(int $id): void
    {
        $this->id = $id;

        $viewPage = new \App\adms\Models\helper\AdmsRead();
        $viewPage->fullRead("SELECT id, name, adms_color_id FROM adms_sits_pgs WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBD = $viewPage->getResult();
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Situação da página não encontrada!</p>";
            $this->result = false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void {
        $this->data['modificado'] = date("Y-m-d H:i:s");

        $upPage = new \App\adms\Models\helper\AdmsUpdate();
        $upPage->exeUpdate("adms_sits_pgs", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upPage->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Situação da página editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação da página não editada com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_col, name name_col FROM adms_colors ORDER BY name ASC");
        $registry['col'] = $list->getResult();

        $this->listRegistryEdit = ['col' => $registry['col']];

        return $this->listRegistryEdit;
    }
}
