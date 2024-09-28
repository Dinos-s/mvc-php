<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar o usuário no banco de dados
 *
 * @author Celke
 */
class AdmsEditPages
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

    public function viewPage(int $id): void
    {
        $this->id = $id;

        $viewPage = new \App\adms\Models\helper\AdmsRead();
        $viewPage->fullRead(
            "SELECT pg.id, pg.controller, pg.metodo, pg.menu_controller, pg.menu_metodo, pg.name_page, 
            pg.publish, pg.icon, pg.obs, pg.adms_sits_pgs_id, pg.adms_types_pgs_id, pg.adms_groups_pgs_id,
            tpg.type type_tpg, tpg.name name_tpg,
            sit.name name_sit, grpg.name name_grpg
            FROM adms_pages AS pg
            LEFT JOIN adms_types_pgs AS tpg ON tpg.id=pg.adms_types_pgs_id
            LEFT JOIN adms_sits_pgs AS sit ON sit.id=pg.adms_sits_pgs_id
            LEFT JOIN adms_groups_pgs AS grpg ON grpg.id=pg.adms_groups_pgs_id
            WHERE pg.id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBD = $viewPage->getResult();
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Página não encontrada!</p>";
            $this->result = false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataExitVal['icon'] = $this->data['icon'];
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['icon'], $this->data['obs']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void {
        $this->data['icon'] = $this->dataExitVal['icon'];
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['modificado'] = date("Y-m-d H:i:s");

        $upPage = new \App\adms\Models\helper\AdmsUpdate();
        $upPage->exeUpdate("adms_pages", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upPage->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Página editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Página não editada com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_pgs ORDER BY name ASC");
        $registry['sit_pg'] = $list->getResult();

        $listType = new \App\adms\Models\helper\AdmsRead();
        $listType->fullRead("SELECT id id_type, name name_type  FROM adms_types_pgs ORDER BY name ASC");
        $registry['type_pg'] = $listType->getResult();

        $listGroup = new \App\adms\Models\helper\AdmsRead();
        $listGroup->fullRead("SELECT id id_group, name name_group FROM adms_groups_pgs ORDER BY name ASC");
        $registry['group_pg'] = $listGroup->getResult();

        $this->listRegistryEdit = [
            'sit_pg' => $registry['sit_pg'],
            'type_pg' => $registry['type_pg'],
            'group_pg' => $registry['group_pg']
        ];

        return $this->listRegistryEdit;
    }
}
