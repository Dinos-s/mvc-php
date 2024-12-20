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
class AdmsDeleteUsers
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var string $delDirectory Recebe o endereço para apagar o diretório */
    private string $delDirectory;

    /** @var string $delImg Recebe o endereço para apagar a imagem */
    private string $delImg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    public function deleteUser(int $id): void
    {
        $this->id = (int) $id;

        if($this->viewUser()){
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_users", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteUser->getResult()) {
                $this->deleteImg();
                $_SESSION['msg'] = "<p style='color: green;'>Usuário apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não apagado com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }

    private function viewUser(): bool
    {

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead(
            "SELECT usr.id, usr.image 
            FROM adms_users AS usr 
            INNER JOIN adms_access_levels AS lev 
            ON lev.id=usr.adms_access_levels_id
            WHERE usr.id=:id AND lev.order_levels >:order_levels
            LIMIT :limit",
            "id={$this->id}&order_levels=". $_SESSION['order_levels'] ."&limit=1"
        );

        $this->resultBD = $viewUser->getResult();
        if ($this->resultBD) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            return false;
        }
    }

    private function deleteImg(): void
    {
        if((!empty($this->resultBD[0]['image'])) or ($this->resultBD[0]['image'] != null)){
            $this->delDirectory = "app/adms/assets/image/users/" . $this->resultBD[0]['id'];
            $this->delImg = $this->delDirectory . "/" . $this->resultBD[0]['image'];

            if(file_exists($this->delImg)){
                unlink($this->delImg);
            }

            if(file_exists($this->delDirectory)){
                rmdir($this->delDirectory);
            }
        }
    }
}
