<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes do Grupo de Páginas</h2>";

echo "<a href='" . URLADM . "list-groups-pages/index'>Listar</a><br>";
if (!empty($this->data['viewPage'])) {
    echo "<a href='" . URLADM . "edit-groups-pages/index/" . $this->data['viewPage'][0]['id'] . "'>Editar</a><br>";
    echo "<a href='" . URLADM . "edit-groups-pages-image/index/" . $this->data['viewPage'][0]['id'] . "'>Editar Imagem</a><br>";
    echo "<a href='" . URLADM . "delete-groups-pages/index/" . $this->data['viewPage'][0]['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewGroupsPages'])) {
    //var_dump($this->data['viewGroupsPages'][0]);
    extract($this->data['viewGroupsPages'][0]);
    // var_dump($this->data['viewGroupsPages']);

    echo "ID: $id <br>";
    echo "Nome do grupo: $name <br>";
    echo "Ordem: $order_gorup_pg <br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";

    if (!empty($modificado)) {
        echo date('d/m/Y H:i:s', strtotime($modificado));
    }
    echo "<br>";
}
