<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes do Usuário</h2>";

echo "<a href='" . URLADM . "list-access-levels/index'>Listar</a><br>";
if (!empty($this->data['viewAccessLevels'])) {
    echo "<a href='" . URLADM . "edit-access-levels/index/" . $this->data['viewAccessLevels'][0]['id'] . "'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-access-levels/index/" . $this->data['viewAccessLevels'][0]['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewAccessLevels'])) {
    //var_dump($this->data['viewAccessLevels'][0]);
    extract($this->data['viewAccessLevels'][0]);
    // var_dump($this->data['viewAccessLevels']);

    echo "ID: $id <br>";
    echo "Nome: $name <br>";
    echo "Ordem: $order_levels <br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";

    if (!empty($modificado)) {
        echo date('d/m/Y H:i:s', strtotime($modificado));
    }
    echo "<br>";
}
