<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar uma páginas
 * @author Cesar <cesar@celke.com.br>
 */
class EditPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar página.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações do grupo no banco de dados, se encontrar instancia o método "viewEditPages". Se não existir redireciona para o listar grupo de página.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editPages".
     *  
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditPages']))) {
            $this->id = (int) $id;
            $viewPages = new \App\adms\Models\AdmsEditPages();
            $viewPages->viewPage($this->id);
            if ($viewPages->getResult()) {
                $this->data['form'] = $viewPages->getResultBd();
                $this->viewEditPages();
            } else {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");*/
            $this->editPages();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditPages(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/pages/editPages", $this->data);
        $loadView->loadView();
    }

    private function editPages(): void
    {
        if (!empty($this->dataForm['SendEditPages'])) {
            unset($this->dataForm['SendEditPages']);
            $editPages = new \App\adms\Models\AdmsEditPages();
            $editPages->update($this->dataForm);
            if($editPages->getResult()){
                $urlRedirect = URLADM . "view-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditPages();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Página não encontrada!</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
