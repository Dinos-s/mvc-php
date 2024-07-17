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
class EditColors
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditColor']))) {
            $this->id = (int) $id;
            $viewUser = new \App\adms\Models\AdmsEditColors();
            $viewUser->viewColor($this->id);
            if ($viewUser->getResult()) {
                $this->data['form'] = $viewUser->getResultBd();
                $this->viewEditColor();
            } else {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            }
        } else {
            /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");*/
            $this->editColor();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditColor(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/colors/editColor", $this->data);
        $loadView->loadView();
    }

    private function editColor(): void
    {
        if (!empty($this->dataForm['SendEditColor'])) {
            unset($this->dataForm['SendEditColor']);
            $editColor = new \App\adms\Models\AdmsEditColors();
            $editColor->update($this->dataForm);
            if($editColor->getResult()){
                $urlRedirect = URLADM . "view-colors/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditColor();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor não encontrado!</p>";
            $urlRedirect = URLADM . "list-colors/index";
            header("Location: $urlRedirect");
        }
    }
}
