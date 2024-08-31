<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o usuário no banco de dados
 *
 * @author Celke
 */
class AdmsSyncPagesLevels
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var array|null $resultBdLevels Recebe os registros do banco de dados */
    private array|null $resultBdLevels;

    /** @var array|null $resultBdPages Recebe os registros do banco de dados */
    private array|null $resultBdPages;

    /** @var array|null $resultBdLevelPages Recebe os registros do banco de dados */
    private array|null $resultBdLevelPage;

    /** @var array|null $levelId Recebe o id do nível de acesso */
    private int|string|null $levelId;

    /** @var array|null $pageId Recebe o id da página */
    private int|string|null $pageId;

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

    public function syncPagesLevels(): void
    {
        $listLevels = new \App\adms\Models\helper\AdmsRead();
        $listLevels->fullRead("SELECT id FROM adms_access_levels");

        $this->resultBdLevels = $listLevels->getResult();        
        if ($this->resultBdLevels) {
            $this->result = true;
            // var_dump($this->resultBdLevels);
            $this->listPages();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nível de acesso não encontrado!</p>";
            $this->result = false;
        }
    }

    private function listPages(): void
    {
        $listPages = new \App\adms\Models\helper\AdmsRead();
        $listPages->fullRead("SELECT id, publish FROM adms_pages");

        $this->resultBdPages = $listPages->getResult();        
        if ($this->resultBdPages) {
            $this->result = true;
            // var_dump($this->resultBdPages);
            $this->readLevels();
        } else { 
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma página encontrada!!</p>";
            $this->result = false;
        }
    }

    private function readLevels(): void
    {
        foreach($this->resultBdLevels as $level){
            extract($level);
            echo "ID do nível de acesso: $id <br>";
            $this->levelId = $id;
            $this->readPages();
        }
        
    }

    private function readPages() {
        foreach($this->resultBdPages as $page) {
            extract($page);
            echo "ID da página: $id <br>";
            $this->pageId = $id;
            $this->serchLevelPage();
        }
    }    

    private function serchLevelPage(): void
    {
        $serchLevelPage = new \App\adms\Models\helper\AdmsRead();
        $serchLevelPage->fullRead(
            "SELECT id FROM adms_levels_pages
            WHERE adms_access_level_id =:adms_access_level_id
            AND adms_page_id =:adms_page_id",
            "adms_access_level_id={$this->levelId}&adms_page_id={$this->pageId}"
        );

        $this->resultBdLevelPage = $serchLevelPage->getResult();        
        if ($this->resultBdLevelPage) {
            // $this->result = true;
            echo "O nível de acesso tem cadastro para a página: {$this->pageId}";
        } else { 
            echo "O nível de acesso não tem cadastro para a página: {$this->pageId}";
            // $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma página encontrada!!</p>";
            $this->result = false;
        }
    }
}
