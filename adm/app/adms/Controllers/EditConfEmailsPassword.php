<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar senha do usuário
 * @author Cesar <cesar@celke.com.br>
 */
class EditConfEmailsPassword
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditConfEmailsPass']))) {
            $this->id = (int) $id;
            $viewConfEmailsPass = new \App\adms\Models\AdmsEditConfEmailsPassword();
            $viewConfEmailsPass->viewConfEmailsPassword($this->id);
            if ($viewConfEmailsPass->getResult()) {
                $this->data['form'] = $viewConfEmailsPass->getResultBd();
                $this->viewEditConfEmailsPass();
            } else {
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editConfEmailsPass();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditConfEmailsPass(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/confEmails/editConfEmailPass", $this->data);
        $loadView->loadView();
    }

    private function editConfEmailsPass(): void
    {
        if (!empty($this->dataForm['SendEditConfEmailsPass'])) {
            unset($this->dataForm['SendEditConfEmailsPass']);
            $editConfEmailsPass = new \App\adms\Models\AdmsEditConfEmailsPassword();
            $editConfEmailsPass->update($this->dataForm);
            if($editConfEmailsPass->getResult()){
                $urlRedirect = URLADM . "view-conf-emails/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditConfEmailsPass();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Configuração de email não encontrada!</p>";
            $urlRedirect = URLADM . "list-conf-emails/index";
            header("Location: $urlRedirect");
        }
    }
}
