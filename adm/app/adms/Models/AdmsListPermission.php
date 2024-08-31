<?php 
    namespace App\adms\Models;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    // Model para listar ass permissão das páginas 
    class AdmsListPermission {
        private bool $result;
        private array|null $resultBD;
        private array|null $resultBdLevel;
        private int $page;
        private int $level;
        private int $limitResult = 40;
        private string|null $resultPg;

        function getResult(){
            return $this->result;
        }

        function getResultBd(): array|null {
            return $this->resultBD;
        }

        function getResultBdLevel(): array|null {
            return $this->resultBdLevel;
        }

        function getResultPg(): string|null {
            return $this->resultPg;
        }

        public function listPermission(int $page = null, int $level = null):void {
            $this->page = (int) $page ? $page : 1;
            $this->level = (int) $level;

            if ($this->viewAccessLevels()) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM .'list-permission/index', "?level={$this->level}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination(
                    "SELECT COUNT(id) AS num_result 
                    FROM adms_levels_pages
                    WHERE adms_access_level_id =:adms_access_level_id",
                    "adms_access_level_id={$this->level}"
                );
                $this->resultPg = $pagination->getResult();

                $listPermissions = new \App\adms\Models\helper\AdmsRead();
                $listPermissions->fullRead(
                    "SELECT lev_pag.id, lev_pag.permission, lev_pag.order_level_page, lev_pag.adms_page_id, pag.name_page
                    FROM adms_levels_pages AS lev_pag
                    LEFT JOIN adms_pages AS pag
                    ON pag.id = adms_page_id
                    WHERE lev_pag.adms_access_level_id = :adms_access_level_id 
                    ORDER BY lev_pag.order_level_page ASC
                    LIMIT :limit OFFSET :offset",
                    "adms_access_level_id={$this->level}&limit={$this->limitResult}&offset={$pagination->getOffset()}"
                );

                $this->resultBD = $listPermissions->getResult();
                if ($this->resultBD) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nenhuma permissão encontrada para o nível de acesso!</p>";
                    $this->result = false;
                }
            } else {
                $this->result = false;
            }
        }

        private function viewAccessLevels():bool {
            $viewAccessLevels = new \App\adms\Models\helper\AdmsRead();
            $viewAccessLevels->fullRead(
                "SELECT name
                FROM adms_access_levels 
                WHERE id=:id AND order_levels >:order_levels
                LIMIT :limit", 
                "id={$this->level}&order_levels=". $_SESSION['order_levels'] ."&limit=1"
            );

            $this->resultBdLevel = $viewAccessLevels->getResult();
            if ($this->resultBdLevel) {
                return true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nível de acesso não encontrado!</p>";
                return false;
            }
        }
    }
?>