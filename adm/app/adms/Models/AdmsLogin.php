<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Validar os dados do login
 *
 * @author GMR
 */
class AdmsLogin
{

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Recupera as informações do usuário no banco de dados
     * Quando encontrar o usuário no banco de dados instanciar o método "valPassword" para validar a senha 
     * Retorna FALSE quando não encontrar usuário no banco de dados
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function login(array $data = null): void
    {
        $this->data = $data;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT usr.id, usr.name, usr.nickname, usr.email, usr.password, usr.image, usr.adms_sits_user_id, usr.adms_access_levels_id,
                            lev.order_levels
                            FROM adms_users AS usr
                            INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_levels_id
                            WHERE usr.user =:user 
                            OR usr.email =:email 
                            LIMIT :limit", "user={$this->data['user']}&email={$this->data['user']}&limit=1");

        $this->resultBD = $viewUser->getResult();
        if ($this->resultBD) {
            $this->valEmailPerm();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
    }

    private function valEmailPerm(): void
    {
        if ($this->resultBD[0]['adms_sits_user_id'] == 1) {
            $this->valPassword();
        } elseif ($this->resultBD[0]['adms_sits_user_id'] == 3) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        } elseif ($this->resultBD[0]['adms_sits_user_id'] == 5) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail descadastrado, entre em contato com a empresa!</p>";
            $this->result = false;
        } elseif ($this->resultBD[0]['adms_sits_user_id'] == 2) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;
        }
    }


    /** 
     * Compara a senha enviado pelo usuário com a senha que está salva no banco de dados
     * Retorna TRUE quando os dados estão corretos e salva as informações do usuário na sessão
     * Retorna FALSE quando a senha está incorreta
     * 
     * @return void
     */
    private function valPassword(): void
    {
        if (password_verify($this->data['password'], $this->resultBD[0]['password'])) {
            $_SESSION['user_id'] = $this->resultBD[0]['id'];
            $_SESSION['user_name'] = $this->resultBD[0]['name'];
            $_SESSION['user_nickname'] = $this->resultBD[0]['nickname'];
            $_SESSION['user_email'] = $this->resultBD[0]['email'];
            $_SESSION['user_image'] = $this->resultBD[0]['image'];
            $_SESSION['adms_access_levels_id'] = $this->resultBD[0]['adms_access_levels_id'];
            $_SESSION['order_levels'] = $this->resultBD[0]['order_levels'];
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
    }
}
