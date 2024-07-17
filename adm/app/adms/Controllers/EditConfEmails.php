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
class EditConfEmails
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditConfEmail']))) {
            $this->id = (int) $id;
            $viewConfEmail = new \App\adms\Models\AdmsEditConfEmails();
            $viewConfEmail->viewConfEmails($this->id);
            if ($viewConfEmail->getResult()) {
                $this->data['form'] = $viewConfEmail->getResultBd();
                $this->viewEditConfEmail();
            } else {
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            }
        } else {
            /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");*/
            $this->editConfEmail();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditConfEmail(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/confEmails/editConfEmail", $this->data);
        $loadView->loadView();
    }

    private function editConfEmail(): void
    {
        if (!empty($this->dataForm['SendEditConfEmail'])) {
            unset($this->dataForm['SendEditConfEmail']);
            $editConfEmail = new \App\adms\Models\AdmsEditConfEmails();
            $editConfEmail->update($this->dataForm);
            if($editConfEmail->getResult()){
                $urlRedirect = URLADM . "view-conf-emails/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditConfEmail();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Configuração de email não encontrada!</p>";
            $urlRedirect = URLADM . "list-conf-emails/index";
            header("Location: $urlRedirect");
        }
    }
}
