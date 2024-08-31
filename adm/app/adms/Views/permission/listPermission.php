<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Permissão do Nível de Acesso: </h2>";

echo "<a href='" . URLADM . "list-access-levels/index' class='btn-info'>Listar Nível de Acesso</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listPermission'] as $permission) {
    // var_dump($permission);
    extract($permission);
    //echo "ID: " . $permission['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Página: $name_page <br>";
    echo "Ordem: $order_level_page <br>";
    echo "Permissão: $permission <br>";
    echo "<hr>";
}

echo $this->data['pagination'];