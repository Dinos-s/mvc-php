<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o usuário no banco de dados
 *
 * @author GMR
 */
class AdmsViewTypesPages
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

    public function viewTypePage(int $id): void
    {
        $this->id = $id;

        $viewTypesPage = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPage->fullRead(
            "SELECT id, type, name, order_type_pg, obs, created, modificado 
            FROM adms_types_pgs 
            WHERE id=:id
            LIMIT :limit", "id={$this->id}&limit=1"
        );

        $this->resultBD = $viewTypesPage->getResult();        
        if ($this->resultBD) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Tipo de página não encontrado!</p>";
            $this->result = false;
        }
    }
}
