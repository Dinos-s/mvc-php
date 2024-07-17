<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar o usuário no banco de dados
 *
 * @author Celke
 */
class AdmsDeleteConfEmails
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    public function deleteConfEmails(int $id): void
    {
        $this->id = (int) $id;

        if($this->viewConfEmails()){
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_confs_emails", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Configuração de email apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Configuração de email não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }

    private function viewConfEmails(): bool
    {
        $viewConfEmails = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmails->fullRead("SELECT id FROM adms_confs_emails WHERE id=:id", "id={$this->id}");

        $this->resultBD = $viewConfEmails->getResult();
        if ($this->resultBD) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Configuração de email não encontrada!</p>";
            return false;
        }
    }
}
