<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes do tipo de página</h2>";

if ($this->data['button']['list_types_pages']) {
    echo "<a href='" . URLADM . "list-types-pages/index'>Listar</a><br>";
}

if (!empty($this->data['viewTypesPages'])) {
    if ($this->data['button']['edit_types_pages']) {
        echo "<a href='" . URLADM . "edit-types-pages/index/" . $this->data['viewTypesPages'][0]['id'] . "'>Editar</a><br>";
    }
    
    if ($this->data['button']['delete_types_pages']) {
        echo "<a href='" . URLADM . "delete-types-pages/index/" . $this->data['viewTypesPages'][0]['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
    }
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewTypesPages'])) {
    //var_dump($this->data['viewUser'][0]);
    extract($this->data['viewTypesPages'][0]);
    // var_dump($this->data['viewUser']);
    echo "ID: $id <br>";
    echo "Tipo: $type <br>";
    echo "Nome: $name <br>";
    echo "Ordem: $order_type_pg <br>";
    echo "Observação: $obs <br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";

    if (!empty($modificado)) {
        echo date('d/m/Y H:i:s', strtotime($modificado));
    }
    echo "<br>";
}
