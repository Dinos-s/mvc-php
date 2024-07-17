<?php
    namespace Core;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    /**
     * Configurações básicas do site.
     *
     * @author Cesar <cesar@celke.com.br>
     */

    abstract class Config {

        protected function configAdm(): void {
            define('URL', 'http://localhost/aprendendo_com_celke/');
            define('URLADM', 'http://localhost/aprendendo_com_celke/adm/');

            define('CONTROLLER', 'Login');
            define('METODO', 'index');
            define('CONTROLLER_ERRO', 'Login');
            
            define('EMAILADM', 'gabriel@gmail.com');

            /**
             * Abaixo são as variáveis de conexão com o banco de dados;
             * Caso necessário mude para adaptar ao seu projeto;
            */
            define('HOST', 'localhost');
            define('USER', 'root');
            define('PASS', '0000');
            define('DBNAME', 'mvc');
            define('PORT', 3306);
        }
    }
?>