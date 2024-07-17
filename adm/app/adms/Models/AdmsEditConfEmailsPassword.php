<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a senha do usuário no banco de dados
 *
 * @author Celke
 */
class AdmsEditConfEmailsPassword
{

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

    public function viewConfEmailsPassword(int $id): void
    {
        $this->id = $id;

        $viewConfEmails = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmails->fullRead(
            "SELECT id FROM adms_confs_emails WHERE id=:id", "id={$this->id}");

        $this->resultBD = $viewConfEmails->getResult();
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Senha da configuração de email não encontrada!</p>";
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

    private function edit(): void
    {
        $this->data['modificado'] = date("Y-m-d H:i:s");

        $upConfEmailsPass = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmailsPass->exeUpdate("adms_confs_emails", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upConfEmailsPass->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Senha da configuração de email editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha da configuração de email não editada com sucesso!</p>";
            $this->result = false;
        }
    }
}
