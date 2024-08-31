<?php 
    namespace App\adms\Controllers;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    // Controller para listar as permissões das páginas
    class ListPermission {
        private array|string|null $data;
        private string|int|null $page;
        private string|int|null $level;

        public function index(string|int|null $page = null) {
            $this->level = filter_input(INPUT_GET, 'level', FILTER_SANITIZE_NUMBER_INT);
            $this->page = (int) $page ? $page : 1;

            $listPermission = new \App\adms\Models\AdmsListPermission();
            $listPermission->listPermission($this->page, $this->level);
            if ($listPermission->getResult()) {
                $this->data['listPermission'] = $listPermission->getResultBd();
                $this->data['viewPermission'] = $listPermission->getResultBdLevel();
                $this->data['pagination'] = $listPermission->getResultPg();
                $this->viewPermission();
            } else {
                $urlRedirect = URLADM ."list-access-levels/index";
                header("Location: $urlRedirect");
            }
        }

        private function viewPermission(): void {
            $loadView = new \Core\ConfigView("adms/Views/permission/listPermission", $this->data);
            $loadView->loadView();
        }
    }
?>