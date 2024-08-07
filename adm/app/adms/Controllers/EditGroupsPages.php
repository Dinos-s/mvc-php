<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar um grupo de páginas
 * @author Cesar <cesar@celke.com.br>
 */
class EditGroupsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar grupos de página.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações do grupo no banco de dados, se encontrar instancia o método "viewEditGroupsPages". Se não existir redireciona para o listar grupo de página.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editGroupsPages".
     *  
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditGroupsPages']))) {
            $this->id = (int) $id;
            $viewGroupsPages = new \App\adms\Models\AdmsEditGroupsPages();
            $viewGroupsPages->viewGroupsPage($this->id);
            if ($viewGroupsPages->getResult()) {
                $this->data['form'] = $viewGroupsPages->getResultBd();
                $this->viewEditGroupsPages();
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");*/
            $this->editGroupsPages();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditGroupsPages(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/editGroupsPages", $this->data);
        $loadView->loadView();
    }

    private function editGroupsPages(): void
    {
        if (!empty($this->dataForm['SendEditGroupsPages'])) {
            unset($this->dataForm['SendEditGroupsPages']);
            $editGroupsPages = new \App\adms\Models\AdmsEditGroupsPages();
            $editGroupsPages->update($this->dataForm);
            if($editGroupsPages->getResult()){
                $urlRedirect = URLADM . "view-groups-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditGroupsPages();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Grupo de página não encontrada!</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
