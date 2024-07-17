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
class AdmsListAccessLevels
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

    public function listAccessLevels(int $page = null):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-access_levels/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_access_levels");
        $this->resultPg = $pagination->getResult();

        $listAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $listAccessLevels->fullRead(
            "SELECT id, name, order_levels FROM adms_access_levels ORDER BY order_levels ASC LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBD = $listAccessLevels->getResult();        
        if($this->resultBD){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }
}
