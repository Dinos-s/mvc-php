<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Usuários</h2>";

if ($this->data['button']['add_conf_emails']) {
    echo "<a href='" . URLADM . "add-conf-emails/index'>Cadastrar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listConfEmails'] as $confEmail) {
    //var_dump($user);
    extract($confEmail);
    //echo "ID: " . $user['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Titulo: $title <br>";
    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";

    if ($this->data['button']['view_conf_emails']) {
        echo "<a href='" . URLADM . "view-conf-emails/index/$id'>Visualizar</a><br>";
    }
    
    if ($this->data['button']['edit_conf_emails']) {
        echo "<a href='" . URLADM . "edit-conf-emails/index/$id'>Editar</a><br>";
    }
    
    if ($this->data['button']['delete_conf_emails']) {
        echo "<a href='" . URLADM . "delete-conf-emails/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
    }
    
    echo "<hr>";
}

echo $this->data['pagination'];