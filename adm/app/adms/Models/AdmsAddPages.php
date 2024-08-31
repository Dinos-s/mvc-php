<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar o Página no banco de dados
 *
 * @author Celke
 */
class AdmsAddPages
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    private array $listRegistryAdd;

    private array $dataExitVal;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;

        $this->dataExitVal['icon'] = $this->data['icon'];
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['icon'], $this->data['obs']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['icon'] = $this->dataExitVal['icon'];
        $this->data['created'] = date("Y-m-d H:i:s");

        $createUser = new \App\adms\Models\helper\AdmsCreate();
        $createUser->exeCreate("adms_pages", $this->data);

        if ($createUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Página cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Página não cadastrada com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_pgs ORDER BY name ASC");
        $registry['sit_pg'] = $list->getResult();

        $listTypePg = new \App\adms\Models\helper\AdmsRead();
        $listTypePg->fullRead("SELECT id id_type, type, name name_type
            FROM adms_types_pgs ORDER BY name ASC");
        $registry['type_pg'] = $listTypePg->getResult();

        $listGrpPg = new \App\adms\Models\helper\AdmsRead();
        $listGrpPg->fullRead("SELECT id id_grp, name name_grp FROM adms_groups_pgs ORDER BY name ASC");
        $registry['group_pg'] = $listGrpPg->getResult();

        $this->listRegistryAdd = [
            'sit_pg' => $registry['sit_pg'],
            'type_pg' => $registry['type_pg'],
            'group_pg' => $registry['group_pg']
        ];

        return $this->listRegistryAdd;
    }
}
