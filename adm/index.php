<?php
session_start();
ob_start();

// varialvel que desve ser carregada se o login for legitima
define('C8L6K7E', true);

//Carregar o Composer
require './vendor/autoload.php';

//Instanciar a classe ConfigController, responsável em tratar a URL
$home = new Core\ConfigController();

//Instanciar o método para carregar a página/controller
$home->loadPage();
