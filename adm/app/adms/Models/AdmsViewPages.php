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
class AdmsViewPages {

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

    public function viewPages(int $id): void
    {
        $this->id = $id;

        $viewPages = new \App\adms\Models\helper\AdmsRead();
        $viewPages->fullRead(
            "SELECT pg.id, pg.controller, pg.metodo, pg.menu_controller, pg.menu_metodo, pg.name_page, pg.publish, pg.icon, pg.obs, pg.created, pg.modificado, tpg.type type_tpg, tpg.name name_tpg,
            sit.name name_sit, grpg.name name_grpg,
            col.color 
            FROM adms_pages AS pg
            LEFT JOIN adms_types_pgs AS tpg ON tpg.id=pg.adms_types_pgs_id
            LEFT JOIN adms_sits_pgs AS sit ON sit.id=pg.adms_sits_pgs_id
            LEFT JOIN adms_groups_pgs AS grpg ON grpg.id=pg.adms_groups_pgs_id
            LEFT JOIN adms_colors AS col ON col.id=sit.adms_color_id
            FROM adms_pages pg
            WHERE id=:id",
            "id={$this->id}"
        );

        $this->resultBD = $viewPages->getResult();        
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Página não encontrado!</p>";
            $this->result = false;
        }
    }
}
