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
class AdmsListUsers
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

    public function listUsers(int $page = null):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(usr.id) AS num_result FROM adms_users usr 
        INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_levels_id WHERE lev.order_levels >:order_levels", "order_levels=". $_SESSION['order_levels']);
        $this->resultPg = $pagination->getResult();

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead(
            "SELECT usr.id, usr.name AS name_usr, usr.email, usr.adms_sits_user_id, sit.name AS name_sit, col.color  
            FROM adms_users AS usr
            INNER JOIN adms_sits_users AS sit 
            ON sit.id=usr.adms_sits_user_id
            INNER JOIN adms_colors AS col 
            ON col.id=sit.adms_color_id
            INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_levels_id 
            WHERE lev.order_levels >:order_levels
            ORDER BY usr.id DESC
            LIMIT :limit OFFSET :offset", "order_levels=". $_SESSION['order_levels'] ."&limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBD = $listUsers->getResult();        
        if($this->resultBD){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }

    
}
