<?php
    namespace Core;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    class ConfigView {
        /**
         * Instancia a classe, reponsável em carregar a view;
         * @param string $nameView Endereço da view deve ser carregada;
         * @param array|string|null $data Dados que a view irá receber;
        */
        public function __construct(private string $nameView, private array|string|null $data) {}

        /**
         * Confirma se o arquivo a ser procurado existe;
         * 
         * Retornamos para o usuário o mesmo layout, junto com uma opção de menu de navegação para as paginas que instanciam essa função;
         * @return void
        */
        public function loadView():void {
            if(file_exists('app/' . $this->nameView . '.php')){
                include 'app/adms/Views/include/head.php';
                include 'app/adms/Views/include/menu.php';
                include 'app/' .$this->nameView . '.php';
                include 'app/adms/Views/include/footer.php';
            } else {
                die("Erro - página não encontrada: Por favor tente novamente. Se o problema persistir, fale com o nosso administrador: " . EMAILADM);
            }
        }

        /**
         * Nessa função retornamos para algumas paginas o mesmo layout sem a opção de menu;
         * Somente as páginas que instanciam essa função, não teram o menu e navegação; 
        */
        public function loadViewLogin():void {
            if(file_exists('app/' . $this->nameView . '.php')){
                include 'app/adms/Views/include/head_login.php';
                include 'app/' .$this->nameView . '.php';
                include 'app/adms/Views/include/footer_login.php';
            } else {
                die("Erro - página não encontrada: Por favor tente novamente. Se o problema persistir, fale com o nosso administrador: " . EMAILADM);
            }
        }
    }
?>