<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página cadastrar um novo nivel de acesso
 * @author Cesar <cesar@celke.com.br>
 */
class AddAccessLevels
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo nível de acesso. Acessa o IF e instância a classe "AdmsAddAccessLevels" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);        

        if(!empty($this->dataForm['SendAddAccessLevels'])){
            //var_dump($this->dataForm);
            unset($this->dataForm['SendAddAccessLevels']);
            $createAccessLevel = new \App\adms\Models\AdmsAddAccessLevels();
            $createAccessLevel->create($this->dataForm);
            if($createAccessLevel->getResult()){
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewAddAccessLevel();
            }   
        }else{
            $this->viewAddAccessLevel();
        }  
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddAccessLevel(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/accessLevels/addAccessLevel", $this->data);
        $loadView->loadView();
    }
}
