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
class AdmsEditUsers
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

    private array $listRegistryAdd;

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

    public function viewUser(int $id): void
    {
        $this->id = $id;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead(
            "SELECT usr.id, usr.name, usr.nickname, usr.email, usr.user, usr.adms_sits_user_id, usr.adms_access_levels_id
                            FROM adms_users AS usr
                            INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_levels_id
                            WHERE usr.id=:id AND lev.order_levels >:order_levels
                            LIMIT :limit",
            "id={$this->id}&order_levels=". $_SESSION['order_levels'] ."&limit=1"
        );

        $this->resultBD = $viewUser->getResult();
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataExitVal['nickname'] = $this->data['nickname'];
        unset($this->data['nickname']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valInput();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Instanciar o helper "AdmsValEmail" para verificar se o e-mail válido
     * Instanciar o helper "AdmsValEmailSingle" para verificar se o e-mail não está cadastrado no banco de dados, não permitido cadastro com e-mail duplicado
     * Instanciar o helper "validatePassword" para validar a senha
     * Instanciar o helper "validateUserSingleLogin" para verificar se o usuário não está cadastrado no banco de dados, não permitido cadastro com usuário duplicado
     * Instanciar o método "add" quando não houver nenhum erro de preenchimento 
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $this->data['id']);

        $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $this->data['id']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void {
        $this->data['modificado'] = date("Y-m-d H:i:s");
        $this->data['nickname'] = $this->dataExitVal['nickname'];

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Usuário editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_users ORDER BY name ASC");
        $registry['sit'] = $list->getResult();

        // Esse read ler todos a tabela de niveis de acesso e retorna somente os de ordem superior do que o usuário logou
        $listLevel = new \App\adms\Models\helper\AdmsRead();
        $listLevel->fullRead(
            "SELECT id id_lev, name name_lev 
            FROM adms_access_levels 
            WHERE order_levels >:order_levels 
            ORDER BY name ASC", "order_levels=". $_SESSION['order_levels'] // procura os registro de order_levels superior ao atual, do usuario;
        );
        $registry['lev'] = $listLevel->getResult();

        $this->listRegistryAdd = [
            'sit' => $registry['sit'], 
            'lev' => $registry['lev']
        ];

        return $this->listRegistryAdd;
    }
}
