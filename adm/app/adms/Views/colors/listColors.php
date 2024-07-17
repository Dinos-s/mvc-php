<?php
    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    echo "<h2>Listar Cores</h2>";

    echo "<a href='" . URLADM . "add-colors/index'>Cadastrar Cor</a><br><br>";

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    foreach ($this->data['listColors'] as $colors) {
        //var_dump($user);
        extract($colors);
        echo "ID: $id <br>";
        echo "Nome: $name <br>";
        echo "Cor: <span style='color: $color;'>$color</span> <br>";
        echo "<a href='" . URLADM . "view-colors/index/$id'>Visualizar</a><br>";
        echo "<a href='" . URLADM . "edit-colors/index/$id'>Editar</a><br>";
        echo "<a href='" . URLADM . "delete-colors/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
        echo "<hr>";
    }

    echo $this->data['pagination'];
?>