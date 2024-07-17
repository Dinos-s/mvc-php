<?php

namespace Core;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Verificar se existe a classe
 * Carregar a CONTROLLER
 * @author Cesar <cesar@celke.com.br>
 */
class CarregarPgAdm {
    private string $urlController;
    private string $urlMetodo;
    private string $urlParam;
    private string $classLoad;
    private array $listPgPublica;
    private array $listPgPrivada;

    private string $urlSlugController;
    private string $urlSlugMetodo;

    public function loadPage(string|null $urlController, string|null $urlMetodo, string|null $urlParam):void{
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParam = $urlParam;

        $this->pgPublica();

        if (class_exists($this->classLoad)) {
            $this->loadMetodo();
        } else {
            die("Erro - ao carregar a classe: Por fovor, tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
            /*$this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParameter = "";
            $this->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);*/
        }
    }

    private function loadMetodo():void {
        $classLoad = new $this->classLoad();
        if (method_exists($classLoad, $this->urlMetodo)) {
            $classLoad->{$this->urlMetodo}($this->urlParam);
        } else {
            die("Erro - carregar metodo: Por favor tente novamente");
        }
    }


    private function pgPublica():void{
        $this->listPgPublica = ["Login", "Logout", "Erro", "NewUser", "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword"];

        if (in_array($this->urlController, $this->listPgPublica)) {
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        } else {
            $this->pgPrivada();
        }
    }

    //Verificar se a página é privada e chamar o método para verificar se o usuário está logado;
    private function pgPrivada():void {
        $this->listPgPrivada = ["Dashboard", "ListUsers", "ViewUsers", "AddUsers", "EditUsers", "EditUsersPassword", "EditUsersImage", "DeleteUsers", "ViewProfile", "EditProfile", "EditProfilePassword", "EditProfileImage", "ListSitsUsers", "ViewSitsUsers", "AddSitsUsers", "EditSitsUsers", "DeleteSitsUsers", "AddColors", "ListColors", "ViewColors", "EditColors", "DeleteColors", "AddConfEmails", "EditConfEmails", "DeleteConfEmails", "ListConfEmails", "ViewConfEmails", "EditConfEmailsPassword", "AddAccessLevels", "EditAccessLevels", "DeleteAccessLevels", "ListAccessLevels", "ViewAccessLevels"];
        
        if (in_array($this->urlController, $this->listPgPrivada)) {
            $this->verifyLogin();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Página não encontrada!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    // verifica se o usuário está logado;
    private function verifyLogin(): void {
        if((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name']))  and (isset($_SESSION['user_email'])) ){
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Para acessar a página realize o login!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    //Corrigi a escrita da url
    private function slugController(string $slugController): string {
        $this->urlSlugController = $slugController;
        // Converter para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);

        // Converter o traco para espaco em braco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);

        // Converter a primeira letra de cada palavra para maiusculo
        $this->urlSlugController = ucwords($this->urlSlugController);

        // Retirar espaco em branco        
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);

        return $this->urlSlugController;
    }

    //Corrigi a escrita do metodo presente na url
    private function slugMetodo($urlSlugMetodo) : string {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);

        // convert a primeira letra em minusculo
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);

        return $this->urlSlugMetodo;
    }
}
?>