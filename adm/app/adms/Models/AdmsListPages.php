<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar os usuários do banco de dados
 *
 * @author Celke
 */
class AdmsListPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;
    private int $page;
    private int $limitResult = 40;
    private string $resultPg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBD;
    }

    function getResultPg(): string|null {
        return $this->resultPg;
    }

    public function listPages(int $page = null):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-pages/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_pages");
        $this->resultPg = $pagination->getResult();

        $listPages = new \App\adms\Models\helper\AdmsRead();
        $listPages->fullRead(
            "SELECT pg.id, pg.name_page, tpg.type type_tpg, tpg.name name_tpg, sit.name name_sit, col.color 
            FROM adms_pages AS pg
            LEFT JOIN adms_types_pgs AS tpg ON tpg.id=pg.adms_types_pgs_id
            LEFT JOIN adms_sits_pgs AS sit ON sit.id=pg.adms_sits_pgs_id
            LEFT JOIN adms_colors AS col ON col.id=sit.adms_color_id
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset",
            "limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBD = $listPages->getResult();        
        if($this->resultBD){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum página encontrado!</p>";
            $this->result = false;
        }
    }
}
