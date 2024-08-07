<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes da Situação da Página</h2>";

echo "<a href='" . URLADM . "list-sits-pages/index'>Listar</a><br>";
if (!empty($this->data['viewSitPages'])) {
    echo "<a href='" . URLADM . "edit-sits-pages/index/" . $this->data['viewSitPages'][0]['id'] . "'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-sits-pages/index/" . $this->data['viewSitPages'][0]['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewSitPages'])) {
    //var_dump($this->data['viewSits'][0]);
    extract($this->data['viewSitPages'][0]);
    // var_dump($this->data['viewSits']);
    echo "ID: $id <br>";
    echo "Nome: $nome><br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";

    if (!empty($modificado)) {
        echo date('d/m/Y H:i:s', strtotime($modificado));
    }
    echo "<br>";
}
