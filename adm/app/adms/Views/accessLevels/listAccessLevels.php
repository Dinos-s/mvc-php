<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Niveis de Acesso</h2>";

echo "<a href='" . URLADM . "add-access-levels/index'>Cadastrar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listAccessLevels'] as $user) {
    // var_dump($user);
    extract($user);
    //echo "ID: " . $user['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Nome: $name <br>";
    echo "Ordem de acesso: $orderLev <br>";
    echo "<a href='" . URLADM . "order-access-levels/index/$id?pag=". $this->data['pag'] ."'>Ordem</a><br>";
    echo "<a href='" . URLADM . "view-access-levels/index/$id'>Visualizar</a><br>";
    echo "<a href='" . URLADM . "edit-access-levels/index/$id'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-access-levels/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
    echo "<hr>";
}

echo $this->data['pagination'];