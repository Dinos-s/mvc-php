<?php
    namespace Core;

use function PHPSTORM_META\type;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    /**
     * Verificar se existe a classe
     * Carregar a CONTROLLER
     * @author Cesar <cesar@celke.com.br>
     */
    class CarregarPgAdmLevel {
        private string $urlController;
        private string $urlMetodo;
        private string $urlParam;
        private string $classLoad;
        private array|null $resultPage;
        private array|null $resultLevelPage;
        // private array $listPgPublica;
        // private array $listPgPrivada;

        private string $urlSlugController;
        private string $urlSlugMetodo;

        public function loadPage(string|null $urlController, string|null $urlMetodo, string|null $urlParam):void{
            $this->urlController = $urlController;
            $this->urlMetodo = $urlMetodo;
            $this->urlParam = $urlParam;
            $this->searchPages();
        }

        private function searchPages() {
            $searchPages = new \App\adms\Models\helper\AdmsRead();
            $searchPages->fullRead(
                "SELECT pag.id, pag.publish, typ.type
                FROM adms_pages AS pag
                INNER JOIN adms_types_pgs AS typ ON typ.id=pag.adms_types_pgs_id
                WHERE pag.controller =:controller 
                AND pag.metodo =:metodo 
                AND pag.adms_sits_pgs_id =:adms_sits_pgs_id",
                "controller={$this->urlController}&metodo={$this->urlMetodo}&adms_sits_pgs_id=1"
            );
            $this->resultPage = $searchPages->getResult();
            if ($this->resultPage) {
                if ($this->resultPage[0]['publish'] == 1) {
                    $this->classLoad = "\\App\\". $this->resultPage[0]['type'] ."\\Controllers\\". $this->urlController;
                    $this->loadMetodo();
                } else {
                    $this->verifyLogin();
                }
            } else {
                // $_SESSION['msg'] = "<p style='color: #f00'>Erro: Página não encontrada no BD!</p>";
                // $urlRedirect = URLADM ."login/index";
                // header("Location: $urlRedirect");
                die("Erro - página não encontrada: Por favor tente novamente. Se o problema persistir contate o admin: ". EMAILADM);
            }
        }

        private function loadMetodo():void {
            $classLoad = new $this->classLoad();
            if (method_exists($classLoad, $this->urlMetodo)) {
                $classLoad->{$this->urlMetodo}($this->urlParam);
            } else {
                die("Erro - carregar metodo: Por favor tente novamente. Entre em contato com o ADM: ". EMAILADM);
            }
        }

        // verifica se o usuário está logado;
        private function verifyLogin(): void {
            if((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name'])) and (isset($_SESSION['user_email'])) and (isset($_SESSION['adms_access_levels_id'])) and (isset($_SESSION['order_levels']))) {
                $this->searchLevelPages();
            }else{
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Para acessar a página realize o login!</p>";
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
        }

        private function searchLevelPages() {
            $searchLevelPage = new \App\adms\Models\helper\AdmsRead();
            $searchLevelPage->fullRead(
                "SELECT id, permission 
                FROM adms_levels_pages
                WHERE adms_page_id =:adms_page_id 
                AND adms_access_level_id =:adms_access_level_id
                AND permission =:permission",
                "adms_page_id={$this->resultPage[0]['id']}&adms_access_level_id=". $_SESSION['adms_access_levels_id'] ."&permission=1"
            );
            $this->resultLevelPage = $searchLevelPage->getResult();
            if ($this->resultLevelPage) {
                $this->classLoad = "\\App\\". $this->resultPage[0]['type'] ."\\Controllers\\". $this->urlController;
                $this->loadMetodo();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00'>Erro: Permissão nescessária para acessar a página!</p>";
                $urlRedirect = URLADM ."login/index";
                header("Location: $urlRedirect");
            }
        }
    }
?>