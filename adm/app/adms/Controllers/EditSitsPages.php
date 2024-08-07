<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar situção as páginas
 * @author Cesar <cesar@celke.com.br>
 */
class EditSitsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsEditSitsPages" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditSitsPages']))) {
            $this->id = (int) $id;
            $viewPages = new \App\adms\Models\AdmsEditSitsPages();
            $viewPages->viewSitsPage($this->id);
            if ($viewPages->getResult()) {
                $this->data['form'] = $viewPages->getResultBd();
                $this->viewEditSitsPages();
            } else {
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-Pagess/index";
            header("Location: $urlRedirect");*/
            $this->editSitsPages();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditSitsPages(): void
    {        
        $listSelect = new \App\adms\Models\AdmsEditSitsPages();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new \Core\ConfigView("adms/Views/sitsPages/editSitsPages", $this->data);
        $loadView->loadView();
    }

    private function editSitsPages(): void
    {
        if (!empty($this->dataForm['SendEditSitsPages'])) {
            unset($this->dataForm['SendEditSitsPages']);
            $editSitsPages = new \App\adms\Models\AdmsEditSitsPages();
            $editSitsPages->update($this->dataForm);
            if($editSitsPages->getResult()){
                $urlRedirect = URLADM . "view-sits-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditSitsPages();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação das páginas não encontrado!</p>";
            $urlRedirect = URLADM . "list-Pagess/index";
            header("Location: $urlRedirect");
        }
    }
}
