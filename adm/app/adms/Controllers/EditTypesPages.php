<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar um tipo de páginas
 * @author Cesar <cesar@celke.com.br>
 */
class EditTypesPages
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
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações do grupo no banco de dados, se encontrar instancia o método "viewEditTypesPages". Se não existir redireciona para o listar grupo de página.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editTypesPages".
     *  
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditTypesPages']))) {
            $this->id = (int) $id;
            $viewTypesPages = new \App\adms\Models\AdmsEditTypesPages();
            $viewTypesPages->viewTypePage($this->id);
            if ($viewTypesPages->getResult()) {
                $this->data['form'] = $viewTypesPages->getResultBd();
                $this->viewEditTypesPages();
            } else {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");*/
            $this->editTypesPages();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditTypesPages(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/typesPages/editTypesPages", $this->data);
        $loadView->loadView();
    }

    private function editTypesPages(): void
    {
        if (!empty($this->dataForm['SendEditTypesPages'])) {
            unset($this->dataForm['SendEditTypesPages']);
            $editTypesPages = new \App\adms\Models\AdmsEditTypesPages();
            $editTypesPages->update($this->dataForm);
            if($editTypesPages->getResult()){
                $urlRedirect = URLADM . "view-types-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditTypesPages();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tipo de Página não encontrada!</p>";
            $urlRedirect = URLADM . "list-types-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
