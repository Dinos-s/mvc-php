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
class AdmsEditConfEmails
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

    public function viewConfEmails(int $id): void
    {
        $this->id = $id;

        $viewConfEmails = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmails->fullRead("SELECT id, title, name, email, host, username, smtpsecure, port FROM adms_confs_emails WHERE id=:id", "id={$this->id}");

        $this->resultBD = $viewConfEmails->getResult();
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Configuração de email não encontrado!</p>";
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

        $upConfEmail = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmail->exeUpdate("adms_confs_emails", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upConfEmail->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Configuração de email editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Configuração de email não editada com sucesso!</p>";
            $this->result = false;
        }
    }
}
