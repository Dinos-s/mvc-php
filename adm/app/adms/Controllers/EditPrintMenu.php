<?php 
    namespace App\adms\Controllers;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    /** 
     * Controller para editar a permissão
    */
    class EditPrintMenu {
        private array|string|null $data = [];
        private array|null $dataForm;
        private string|int|null $id;

        /** @var int|string|null $level Recebe o nível de acesso*/
        private int|string|null $level;
        
        /** @var int|string|null $pag Recebe o numero da página*/
        private int|string|null $pag;

        public function index (string|int|null $id = null) {
            $this->id = $id;
            $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
            $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

            if ((!empty($this->id)) and (!empty($this->level) and (!empty($this->pag)))) {
                $editPrintMenu = new \App\adms\Models\AdmsEditPrintMenu();
                $editPrintMenu->editPrintMenu($this->id);

                $urlRedirect = URLADM ."list-permission/index/{$this->pag}?level={$this->level}";
                header("Location: $urlRedirect");
            } else {
                $_SESSION['msg'] = "<p style='color: #f00'>Erro: Necessário selecionar uma página para mudar a permissão!</p>";
                $urlRedirect = URLADM ."list-access-levels/index";
                header("Location: $urlRedirect");
            }
        }
    }
?>