<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar o usuário no banco de dados
 *
 * @author GMR
 */
class AdmsAddTypesPages
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    private array $resultadoBd;
    private array $dataExitVal;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    private function add(): void
    {
        if ($this->viewLastTypesPages()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createUser = new \App\adms\Models\helper\AdmsCreate();
            $createUser->exeCreate("adms_types_pgs", $this->data);

            if ($createUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Tipo de página cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tipo de página não cadastrado com sucesso!</p>";
                $this->result = false;
            }
        }
    }

    private function viewLastTypesPages()
    {
        $viewLastTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewLastTypesPages->fullRead("SELECT order_type_pg FROM adms_types_pgs ORDER BY order_type_pg DESC");

        $this->resultadoBd = $viewLastTypesPages->getResult();

        if ($this->resultadoBd) {
            $this->data['order_type_pg'] = $this->resultadoBd[0]['order_type_pg'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tipo de páginas cadastrado com sucesso!</p>";
            return false;
        }
    }
}
