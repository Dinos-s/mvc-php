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
class AdmsViewSitsPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

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

    public function viewSitPage(int $id): void
    {
        $this->id = $id;

        $viewPage = new \App\adms\Models\helper\AdmsRead();
        $viewPage->fullRead(
            "SELECT sit_pgs.id, sit_pgs.name, sit_pgs.created, sit_pgs.modified, col.color
            FROM adms_sits_pgs AS sit_pgs
            INNER JOIN adms_colors AS col ON col.id=sit_pgs.adms_color_id
            WHERE sit_pgs.id=:id
            LIMIT :limit", "id={$this->id}&limit=1"
        );

        $this->resultBD = $viewPage->getResult();        
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Página não encontrada!</p>";
            $this->result = false;
        }
    }
}
