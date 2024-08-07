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
class AdmsDeletePages
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

    public function deleteTypesPages(int $id): void
    {
        $this->id = (int) $id;

        if($this->viewTypePage() && $this->checkStatusPage()){
            $deletePage = new \App\adms\Models\helper\AdmsDelete();
            $deletePage->exeDelete("adms_types_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deletePage->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Tipo dde página apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tipo de página apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }   
    }

    private function viewTypePage(): bool
    {

        $viewPage = new \App\adms\Models\helper\AdmsRead();
        $viewPage->fullRead("SELECT id FROM adms_types_pgs WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBD = $viewPage->getResult();
        if ($this->resultBD) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Tipo de página não encontrada!</p>";
            return false;
        }
    }

    private function checkStatusPage(): bool {
        $viewPageAdd = new \App\adms\Models\helper\AdmsRead();
        $viewPageAdd->fullRead("SELECT id FROM adms_pages WHERE adms_types_pgs_id =:adms_types_pgs_id", "adms_types_pgs_id={$this->id}");

        if ($viewPageAdd->getResult()) {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Tipo de página não pode ser apagada, pois existe usuários com essa situação!</p>";
            return false;
        } else {
            return true;
        }
    }
}
