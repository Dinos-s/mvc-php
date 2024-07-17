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
class AdmsDeleteColors
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

    public function deleteColor(int $id): void
    {
        $this->id = (int) $id;

        if($this->viewColor() && $this->checkColorUsed()){
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_colors", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Cor apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }   
    }

    private function viewColor(): bool
    {

        $viewColor = new \App\adms\Models\helper\AdmsRead();
        $viewColor->fullRead("SELECT id FROM adms_colors WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBD = $viewColor->getResult();
        if ($this->resultBD) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Cor não encontrada!</p>";
            return false;
        }
    }

    private function checkColorUsed(): bool {
        $viewColorUsed = new \App\adms\Models\helper\AdmsRead();
        $viewColorUsed->fullRead("SELECT id FROM adms_sit_users WHERE adms_color_id =:adms_color_id", "adms_color_id={$this->id}");

        if ($viewColorUsed->getResult()) {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Cor não pode ser apagada, pois existe uma situação com essa Cor!</p>";
            return false;
        } else {
            return true;
        }
    }
}
