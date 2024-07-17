<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar usuário
 * @author Cesar <cesar@celke.com.br>
 */
class EditSitsUsers
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditSitsUser']))) {
            $this->id = (int) $id;
            $viewUser = new \App\adms\Models\AdmsEditSitsUsers();
            $viewUser->viewSitsUser($this->id);
            if ($viewUser->getResult()) {
                $this->data['form'] = $viewUser->getResultBd();
                $this->viewEditSitsUser();
            } else {
                $urlRedirect = URLADM . "list-sits-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");*/
            $this->editSitsUser();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditSitsUser(): void
    {        
        $listSelect = new \App\adms\Models\AdmsEditSitsUsers();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new \Core\ConfigView("adms/Views/sitsUser/editSitsUser", $this->data);
        $loadView->loadView();
    }

    private function editSitsUser(): void
    {
        if (!empty($this->dataForm['SendEditSitsUser'])) {
            unset($this->dataForm['SendEditSitsUser']);
            $editSitsUser = new \App\adms\Models\AdmsEditSitsUsers();
            $editSitsUser->update($this->dataForm);
            if($editSitsUser->getResult()){
                $urlRedirect = URLADM . "view-sits-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditSitsUser();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
