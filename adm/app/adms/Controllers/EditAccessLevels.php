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
class EditAccessLevels
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditAccessLevel']))) {
            $this->id = (int) $id;
            $viewAccessLevel = new \App\adms\Models\AdmsEditAccessLevels();
            $viewAccessLevel->viewAccessLevel($this->id);
            if ($viewAccessLevel->getResult()) {
                $this->data['form'] = $viewAccessLevel->getResultBd();
                $this->viewEditAccessLevels();
            } else {
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editAccessLevels();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditAccessLevels(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/accessLevels/editAccessLevel", $this->data);
        $loadView->loadView();
    }

    private function editAccessLevels(): void
    {
        if (!empty($this->dataForm['SendEditAccessLevel'])) {
            unset($this->dataForm['SendEditAccessLevel']);
            $editAccessLevel = new \App\adms\Models\AdmsEditAccessLevels();
            $editAccessLevel->update($this->dataForm);
            if($editAccessLevel->getResult()){
                $urlRedirect = URLADM . "view-access-levels/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditAccessLevels();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nível de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
