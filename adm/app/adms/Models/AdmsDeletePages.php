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

    public function deletePage(int $id): void
    {
        $this->id = (int) $id;

        if($this->viewPages()){
            $deletePage = new \App\adms\Models\helper\AdmsDelete();
            $deletePage->exeDelete("adms_pages", "WHERE id=:id", "id={$this->id}");
    
            if ($deletePage->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Página apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Página não apagado com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }

    private function viewPages(): bool
    {

        $viewPages = new \App\adms\Models\helper\AdmsRead();
        $viewPages->fullRead("SELECT id FROM adms_pages WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBD = $viewPages->getResult();
        if ($this->resultBD) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Página não encontrado!</p>";
            return false;
        }
    }
}
