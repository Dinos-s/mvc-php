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
class AdmsDeleteSitsPages
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

    public function deleteSitsPage(int $id): void
    {
        $this->id = (int) $id;

        if($this->viewPage() && $this->checkStatusPage()){
            $deletePage = new \App\adms\Models\helper\AdmsDelete();
            $deletePage->exeDelete("adms_sits_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deletePage->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Situação da página apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação da página não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }   
    }

    private function viewPage(): bool {
        $viewPage = new \App\adms\Models\helper\AdmsRead();
        $viewPage->fullRead("SELECT id FROM adms_sits_pgs WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBD = $viewPage->getResult();
        if ($this->resultBD) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Situação da página não encontrada!</p>";
            return false;
        }
    }

    private function checkStatusPage(): bool {
        $viewPageAdd = new \App\adms\Models\helper\AdmsRead();
        $viewPageAdd->fullRead("SELECT id FROM adms_pages WHERE adms_sits_pgs_id =:adms_sits_pgs_id", "adms_sits_pgs_id={$this->id}");

        if ($viewPageAdd->getResult()) {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Situação não pode ser apagada, pois existe páginas com essa situação!</p>";
            return false;
        } else {
            return true;
        }
    }
}
