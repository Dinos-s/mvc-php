<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar o usuário no banco de dados
 *
 * @author GMR
 */
class AdmsDeleteGroupsPages
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

    public function deleteGroupsPage(int $id): void
    {
        $this->id = (int) $id;

        if(($this->viewGroupsPages()) and ($this->checkStatusUsed())){
            $deleteGroupsPage = new \App\adms\Models\helper\AdmsDelete();
            $deleteGroupsPage->exeDelete("adms_groups_pgs", "WHERE id=:id", "id={$this->id}");
    
            if ($deleteGroupsPage->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Grupo de páginas apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Grupo de páginas não apagado com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }

    private function viewGroupsPages(): bool
    {

        $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPages->fullRead("SELECT id FROM adms_groups_pgs WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBD = $viewGroupsPages->getResult();
        if ($this->resultBD) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Grupo de páginas não encontrado!</p>";
            return false;
        }
    }

    /**
     * Metodo verifica se tem páginas cadastradas usando o grupo de página a ser excluido, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteGroupsPages
     * @return boolean
    */
    private function checkStatusUsed(): bool {
        $viewPagesAdd = new \App\adms\Models\helper\AdmsRead();
        $viewPagesAdd->fullRead(
            "SELECT id FROM adms_pages WHERE adms_groups_pgs_id =:adms_groups_pgs_id LIMIT :limit",
            "adms_groups_pgs_id={$this->id}&limit1"
        );
        if ($viewPagesAdd->getResult()) {
            $_SESSION['msg'] = "<p class='alert-warning'>Erro: Grupo de páginas não pode ser apagado, há páginas cadastradas com esse grupo!</p>";
            return false;
        }else{
            return true;
        }
    }
}
