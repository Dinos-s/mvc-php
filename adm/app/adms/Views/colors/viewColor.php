<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes da Cor</h2>";

if($this->data['button']['list_colors']){
    echo "<a href='" . URLADM . "list-colors/index'>Listar</a><br>";
}

if (!empty($this->data['viewColor'])) {
    if ($this->data['button']['edit_colors']) {
        echo "<a href='" . URLADM . "edit-colors/index/" . $this->data['viewColor'][0]['id'] . "'>Editar</a><br>";
    }

    if ($this->data['button']['delete_colors']) {
        echo "<a href='" . URLADM . "delete-colors/index/" . $this->data['viewColor'][0]['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
    }
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewColor'])) {
    // var_dump($this->data['viewColor'][0]);
    extract($this->data['viewColor'][0]);
    // var_dump($this->data['viewUser']);
    echo "ID: $id <br>";
    echo "Nome: $name<br>";
    echo "Cor: <span style='color: $color;'>$color</span><br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";

    if (!empty($modificado)) {
        echo date('d/m/Y H:i:s', strtotime($modificado));
    }
    echo "<br>";
}
